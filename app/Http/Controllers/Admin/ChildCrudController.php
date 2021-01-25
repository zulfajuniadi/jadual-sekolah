<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChildRequest;
use App\Models\Child;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Prologue\Alerts\Facades\Alert;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScheduleImport;
use App\Exports\ScheduleExport;
use Illuminate\Http\Request;

/**
 * Class ChildCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChildCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Child::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/child');
        CRUD::setEntityNameStrings('Anak', 'Anak');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => 'Nama',
                'type' => 'avatar_name'
            ]
        ]);


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
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
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ChildRequest::class);

        $this->crud->addFields([[
            'name' => 'name',
            'label' => 'Nama'
        ], [
            'name' => 'avatar_config',
            'label' => 'Avatar',
            'type' => 'avatar'
        ]]);

        // CRUD::setFromDb(); // fields

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

    public function avatar($id)
    {
        $child = Child::findOrFail($id);
        return view('avatar', compact('child'));
    }

    protected function setupScheduleRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/schedule', [
            'as'        => $routeName.'.schedule.show',
            'uses'      => $controller.'@showSchedule',
            'operation' => 'schedule',
        ]);
        Route::get($segment.'/{id}/schedule/get', [
            'as'        => $routeName.'.schedule.get',
            'uses'      => $controller.'@getSchedule',
            'operation' => 'schedule',
        ]);
        Route::post($segment.'/{id}/schedule/import', [
            'as'        => $routeName.'.schedule.import',
            'uses'      => $controller.'@importSchedule',
            'operation' => 'schedule',
        ]);
    }

    public function showSchedule($id) 
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('Schedule');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Schedule '.$this->crud->entity_name;

        return view('vendor.backpack.crud.schedule', $this->data);
    }

    public function importSchedule(Request $request, $id)
    {
        $this->crud->hasAccessOrFail('update');

        $user_id = backpack_user()->id;
        $child_id = $id;

        $File = $request->file('jadual');
        $FileName = date('Y-m-d_h-ia_').$File->getClientOriginalName();
        Storage::disk('public')->putFileAs('imports/', $File, $FileName);
        $schdule = Excel::import(new ScheduleImport($user_id, $child_id), public_path('/storage/imports/'.$FileName));

        // show a success message
        \Alert::success('Jadual berjaya dimuat naik!')->flash();

        return \Redirect::to($this->crud->route);
    }

    protected function setupScheduleDefaults()
    {
        $this->crud->allowAccess('schedule');

        $this->crud->operation('list', function() {
            $this->crud->addButtonFromView('line', 'schedule', 'schedule', 'beginning');  
        });
    }

    public function getSchedule() 
    {
        return Excel::download(new ScheduleExport, 'jadualku.xlsx');
    }
}
