<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ScheduleRequest;
use App\Models\Child;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

/**
 * Class ScheduleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ScheduleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Schedule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/schedule');
        CRUD::setEntityNameStrings('schedule', 'schedules');
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $data = $this->crud->getStrippedSaveRequest();
        $data['user_id'] = backpack_user()->id;
        $item = $this->crud->create($data);
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([
            'name'  => 'child',
            'type'  => 'dropdown',
            'label' => 'Child'
        ], Child::orderBy('name')->pluck('name', 'id')->toArray(), function($value) { // if the filter is active
            $this->crud->addClause('where', 'child_id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'day',
            'type'  => 'dropdown',
            'label' => 'Day'
        ], [
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
            '7' => 'Sunday',
        ], function($value) { // if the filter is active
            $this->crud->addClause('where', 'day', $value);
        });

        // CRUD::setFromDb(); // columns
        $this->crud->addColumns([
            [
                'name' => 'child_id',
                'type' => 'select',
                'entity' => 'child', 
                'model' => Child::class,
                'attribute' => 'name' 
            ],
            [
                'name' => 'day',
                'type' => 'select_from_array',
                'options' => [
                    '1' => 'Monday',
                    '2' => 'Tuesday',
                    '3' => 'Wednesday',
                    '4' => 'Thursday',
                    '5' => 'Friday',
                    '6' => 'Saturday',
                    '7' => 'Sunday',
                ],
            ],
            'start_time',
            'end_time',
            'name',
            [
                'name' => 'class_url',
                'type' => 'url',
            ],
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ScheduleRequest::class);

        $this->crud->addFields([
            [
                'name' => 'child_id',
                'type' => 'select',
                'entity' => 'child', 
                'model' => Child::class,
                'attribute' => 'name' 
            ],
            [
                'name' => 'day',
                'type' => 'select_from_array',
                'options' => [
                    '1' => 'Monday',
                    '2' => 'Tuesday',
                    '3' => 'Wednesday',
                    '4' => 'Thursday',
                    '5' => 'Friday',
                    '6' => 'Saturday',
                    '7' => 'Sunday',
                ],
            ],
            'start_time',
            'end_time',
            'name',
            [
                'name' => 'class_url',
                'type' => 'url'
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCloneDefaults()
    {
        $this->crud->allowAccess('clone');

        $this->crud->operation('clone', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation(['list', 'show'], function () {
            $this->crud->addButton('line', 'clone', 'view', 'crud::buttons.clone', 'start');
        });
    }
    
    protected function setupCloneRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/clone', [
            'as'        => $routeName.'.clone',
            'uses'      => $controller.'@clone',
            'operation' => 'clone',
        ]);
    }
    
    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');

        $clonedEntry = $this->crud->model->findOrFail($id)->replicate();

        $clonedEntry->push();

        return redirect('/app/schedule/' . $clonedEntry->id . '/edit');
    }
}
