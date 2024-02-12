<?php

namespace App\Http\Controllers\Office\ProjectManagement;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Advisor;
use App\Models\Developer;
use App\Models\Employee;
use App\Models\Owner;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Project;
use App\Models\PropertyType;
use App\Models\PropertyUsage;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $Projects = Project::where('office_id', Auth::user()->UserOfficeData->id)->get();
        return view('Office.ProjectManagement.Project.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        $advisors = Advisor::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $developers = Developer::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $owners = Owner::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $employees = Employee::where('office_id', Auth::user()->UserOfficeData->id)->get();
        return view('Office.ProjectManagement.Project.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'developer_id' => 'required|exists:developers,id',
            'advisor_id' => 'required|exists:advisors,id',
            'employee_id' => 'required|exists:employees,id',
            'owner_id' => 'required|exists:owners,id',
        ];
        $request_data = $request->all();
        $request_data['office_id'] = Auth::user()->UserOfficeData->id;
        $request->validate($rules);
        if ($request->image) {
            $file = $request->File('image');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Offices/' . 'Projects/', $ext);
            $request_data['image'] = '/Offices/' . 'Projects/' . $ext;
        }
        Project::create($request_data);
        return redirect()->route('Office.Project.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::find($id);
        return view('Office.ProjectManagement.Project.show', get_defined_vars());
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $Regions = Region::all();
        $cities = City::all();
        $advisors = Advisor::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $developers = Developer::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $owners = Owner::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $employees = Employee::where('office_id', Auth::user()->UserOfficeData->id)->get();
        return view('Office.ProjectManagement.Project.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'developer_id' => 'required|exists:developers,id',
            'advisor_id' => 'required|exists:advisors,id',
            'employee_id' => 'required|exists:employees,id',
            'owner_id' => 'required|exists:owners,id',
        ];
        $request_data = $request->all();
        $request_data['office_id'] = Auth::user()->UserOfficeData->id;
        $request->validate($rules);
        if ($request->image) {
            $file = $request->File('image');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Offices/' . 'Projects/', $ext);
            $request_data['image'] = '/Offices/' . 'Projects/' . $ext;
        }
        $project->update($request_data);
        return redirect()->route('Office.Project.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Advisor::find($id)->delete();
        return redirect()->route('Office.Advisor.index')->with('success', __('Deleted successfully'));
    }
    function CreateProperty($id)
    {
        $project = Project::find($id);
        $Regions = Region::all();
        $cities = City::all();
        $types = PropertyType::get();
        $usages = PropertyUsage::get();
        $developers = Developer::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $owners = Owner::where('office_id', Auth::user()->UserOfficeData->id)->get();
        $employees = Employee::where('office_id', Auth::user()->UserOfficeData->id)->get();

        return view('Office.ProjectManagement.Project.CreateProperty', get_defined_vars());
    }
}