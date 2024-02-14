<?php

namespace App\Http\Controllers\Broker\ProjectManagement;

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
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\PropertyUsage;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $Projects = Project::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        return view('Broker.ProjectManagement.Project.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Regions = Region::all();
        $cities = City::all();
        $advisors = Advisor::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        $developers = Developer::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        $owners = Owner::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        // $employees = Employee::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        return view('Broker.ProjectManagement.Project.create', get_defined_vars());
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
            'owner_id' => 'required|exists:owners,id',
        ];
        $request_data = $request->all();
        $request_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $request->validate($rules);
        if ($request->image) {
            $file = $request->File('image');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Brokers/' . 'Projects/', $ext);
            $request_data['image'] = '/Brokers/' . 'Projects/' . $ext;
        } else {
            $request_data['image'] = '/Brokers/Projects/default.svg';
        }
        Project::create($request_data);
        return redirect()->route('Broker.Project.index')->with('success', __('added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::find($id);
        // $project->PropertiesProject
        return view('Broker.ProjectManagement.Project.show', get_defined_vars());
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $Regions = Region::all();
        $cities = City::all();
        $advisors = Advisor::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        $developers = Developer::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        $owners = Owner::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        // $employees = Employee::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        return view('Broker.ProjectManagement.Project.edit', get_defined_vars());
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
            'owner_id' => 'required|exists:owners,id',
        ];
        $request_data = $request->all();
        $request_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $request->validate($rules);
        if ($request->image) {
            $file = $request->File('image');
            $ext  =  uniqid() . '.' . $file->clientExtension();
            $file->move(public_path() . '/Brokers/' . 'Projects/', $ext);
            $request_data['image'] = '/Brokers/' . 'Projects/' . $ext;
        } else {
            $request_data['image'] = '/Brokers/Projects/default.svg';
        }
        $project->update($request_data);
        return redirect()->route('Broker.Project.index')->with('success', __('Update successfully'));
    }

    public function destroy(string $id)
    {
        Project::find($id)->delete();
        return redirect()->route('Broker.Project.index')->with('success', __('Deleted successfully'));
    }
    function CreateProperty($id)
    {
        $project = Project::find($id);
        $Regions = Region::all();
        $cities = City::all();
        $types = PropertyType::get();
        $usages = PropertyUsage::get();
        $developers = Developer::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        $owners = Owner::where('broker_id', Auth::user()->UserBrokerData->id)->get();
        // $employees = Employee::where('broker_id', Auth::user()->UserBrokerData->id)->get();

        return view('Broker.ProjectManagement.Project.CreateProperty', get_defined_vars());
    }

    function StoreProperty(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'property_type_id' => 'required|exists:property_types,id',
            'property_usage_id' => 'required|exists:property_usages,id',
            'owner_id' => 'required|exists:owners,id',
        ];
        $request->validate($rules);
        $request_data = $request->except('images');
        $request_data['broker_id'] = Auth::user()->UserBrokerData->id;
        $request_data['project_id'] = $id;

        $Property = Property::create($request_data);
        if ($request->images) {
            foreach ($request->images as  $item) {
                $ext  =  uniqid() . '.' . $item->clientExtension();
                $item->move(public_path() . '/Brokers/Projects/Property/', $ext);
                $request_image['image'] = '/Brokers/Projects/Property/' .  $ext;
                $request_image['property_id'] = $Property->id;
                PropertyImage::create($request_image);
            }
        }
        return redirect()->route('Broker.Project.show', $id)->with('success', __('added successfully'));
    }
}
