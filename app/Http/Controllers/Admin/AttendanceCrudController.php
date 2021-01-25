<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttendanceRequest;
use App\Models\Child;
use App\Models\Schedule;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AttendanceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttendanceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Attendance::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attendance');
        CRUD::setEntityNameStrings('Kehadiran', 'Kehadiran');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'child_id',
                'type' => 'select',
                'entity' => 'child', 
                'model' => Child::class,
                'attribute' => 'name',
                'label' => 'Anak',
            ],
            [
                'name' => 'schedule_id',
                'label' => 'Kelas',
                'type' => 'select',
                'entity' => 'schedule', 
                'model' => Schedule::class,
                'attribute' => 'attendance_display',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('schedule', function($query) use ($searchTerm) {
                        $query->where('name', 'like', '%'.$searchTerm.'%');
                    });
                }
            ],
            [
                'name' => 'class_date',
                'label' => 'Tarikh Kelas',
                'type' => 'date',
            ],
            [
                'name' => 'attended_at',
                'label' => 'Hadir Pada',
            ],
        ]);

        $this->crud->addFilter([
            'name'  => 'child',
            'type'  => 'dropdown',
            'label' => 'Anak'
        ], Child::orderBy('name')->pluck('name', 'id')->toArray(), function($value) { // if the filter is active
            $this->crud->addClause('where', 'child_id', $value);
        });

        $this->crud->addFilter([
            'type'  => 'date',
            'name'  => 'class_date',
            'label' => 'Tarikh'
          ],
        false,
          function ($value) { // if the filter is active, apply these constraints
            $this->crud->addClause('where', 'class_date', $value);
        });

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
        CRUD::setValidation(AttendanceRequest::class);

        CRUD::setFromDb(); // fields

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
}
