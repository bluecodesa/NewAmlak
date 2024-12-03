<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Advertising;
// use App\Models\PartnerSuccess;
// use Carbon\Carbon;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Validator;

// class AdvertisingController  extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//         $Ads = Advertising::all();
//         $today = Carbon::today();

//         Advertising::where('show_end_date', '<', $today)
//         ->where('status', '!=', 'Finished')
//         ->update(['status' => 'Finished']);

//         // Update ads that have a start date today or less and end date today or greater to 'Published'
//         Advertising::where('show_start_date', '<=', $today)
//         ->whereNotIn('status', ['Published', 'Finished'])
//         ->update(['status' => 'Published']);


//         return view('Admin.Advertising.index', get_defined_vars());
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//         return view('Admin.Advertising.create', get_defined_vars());
//     }

//     /**
//      * Store a newly created resource in storage.
//      */


//      public function store(Request $request)
//      {
//          // Validate the input data
//          $request->validate([
//                 'ad_name' => 'required|string|max:255',
//                 'content' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv,flv,pdf,doc,docx|max:20480',
//                 'client_name' => 'nullable|string|max:255',
//                 'ad_url' => 'nullable|string|max:255',
//                 'show_start_date' => 'required|date|after_or_equal:today',
//                 'show_end_date' => 'required|date|after:show_start_date',
//                 'ad_duration' => 'required|integer|min:1',
//          ], [
//             'ad_name.required' => 'The ad name is required.',
//             'ad_name.string' => 'The ad name must be a string.',
//             'ad_name.max' => 'The ad name may not be greater than 255 characters.',

//             'content.required' => 'The content file is required.',
//             'content.file' => 'The content must be a file.',
//             'content.mimes' => 'The content must be a file of type: jpg, jpeg, png, gif, mp4, mov, avi, wmv, flv, pdf, doc, docx.',
//             'content.max' => 'The content may not be greater than 20 MB.',

//             'client_name.string' => 'The client name must be a string.',
//             'client_name.max' => 'The client name may not be greater than 255 characters.',

//             'show_start_date.required' => 'The display start date is required.',
//             'show_start_date.date' => 'The display start date is not a valid date.',
//             'show_start_date.after_or_equal' => 'The display start date must be today or a future date.',

//             'show_end_date.required' => 'The display end date is required.',
//             'show_end_date.date' => 'The display end date is not a valid date.',
//             'show_end_date.after' => 'The display end date must be after the display start date.',

//             'ad_duration.required' => 'The ad display duration is required.',
//             'ad_duration.integer' => 'The ad display duration must be an integer.',
//             'ad_duration.min' => 'The ad display duration must be at least 1 day.',
//          ]);

//          $data = [];
//          if ($request->hasFile('content')) {
//              $content = $request->file('content');
//              $ext = $content->getClientOriginalExtension();
//              $contentName = uniqid() . '.' . $ext;
//              $content->move(public_path('/Admin/Advertisings/Files/'), $contentName);
//              $data['content'] = '/Admin/Advertisings/Files/' . $contentName;
//          }

//          // Determine status based on start date
//          $showStartDate = new \DateTime($request->input('show_start_date'));
//          $currentDate = new \DateTime();
//          if ($showStartDate->format('Y-m-d') === $currentDate->format('Y-m-d')) {
//              $data['status'] = 'Published';
//          } else {
//              $data['status'] = 'Scheduled';
//          }

//          // Additional data
//          $data['ad_name'] = $request->input('ad_name');
//          $data['client_name'] = $request->input('client_name');
//          $data['ad_url'] = $request->input('ad_url');
//          $data['ad_duration'] = $request->input('ad_duration');
//          $data['show_start_date'] = $request->input('show_start_date');
//          $data['show_end_date'] = $request->input('show_end_date');

//          // Create the advertising entry
//          Advertising::create($data);


//          return redirect()->route('Admin.Advertisings.index')->with('success', __('Ad created successfully'));
//      }


//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//         $advertisement = Advertising::findOrFail($id);

//         return view('Admin.Advertising.show', get_defined_vars());

//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit($id)
//     {
//         $advertising = Advertising::findOrFail($id);
//         return view('Admin.Advertising.edit', compact('advertising'));
//     }

//     public function update(Request $request, $id)
//     {
//         // Validate the input data
//         $request->validate([
//             'ad_name' => 'required|string|max:255',
//             'content' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv,flv,pdf,doc,docx|max:20480',
//             'client_name' => 'nullable|string|max:255',
//             'ad_url' => 'nullable|string|max:255',
//             'show_start_date' => 'required|date|after_or_equal:today',
//             'show_end_date' => 'required|date|after:show_start_date',
//             'ad_duration' => 'required|integer|min:1',
//         ], [
//            'ad_name.required' => 'The ad name is required.',
//             'ad_name.string' => 'The ad name must be a string.',
//             'ad_name.max' => 'The ad name may not be greater than 255 characters.',

//             'content.required' => 'The content file is required.',
//             'content.file' => 'The content must be a file.',
//             'content.mimes' => 'The content must be a file of type: jpg, jpeg, png, gif, mp4, mov, avi, wmv, flv, pdf, doc, docx.',
//             'content.max' => 'The content may not be greater than 20 MB.',

//             'client_name.string' => 'The client name must be a string.',
//             'client_name.max' => 'The client name may not be greater than 255 characters.',

//             'show_start_date.required' => 'The display start date is required.',
//             'show_start_date.date' => 'The display start date is not a valid date.',
//             'show_start_date.after_or_equal' => 'The display start date must be today or a future date.',

//             'show_end_date.required' => 'The display end date is required.',
//             'show_end_date.date' => 'The display end date is not a valid date.',
//             'show_end_date.after' => 'The display end date must be after the display start date.',

//             'ad_duration.required' => 'The ad display duration is required.',
//             'ad_duration.integer' => 'The ad display duration must be an integer.',
//             'ad_duration.min' => 'The ad display duration must be at least 1 day.',
//         ]);

//         $advertising = Advertising::findOrFail($id);

//         $data = [];
//         if ($request->hasFile('content')) {
//             $content = $request->file('content');
//             $ext = $content->getClientOriginalExtension();
//             $contentName = uniqid() . '.' . $ext;
//             $content->move(public_path('/Admin/Advertisings/Files/'), $contentName);
//             $data['content'] = '/Admin/Advertisings/Files/' . $contentName;
//         }

//         // Determine status based on start date
//         $showStartDate = new \DateTime($request->input('show_start_date'));
//         $currentDate = new \DateTime();
//         if ($showStartDate->format('Y-m-d') === $currentDate->format('Y-m-d')) {
//             $data['status'] = 'Published';
//         } else {
//             $data['status'] = 'Scheduled';
//         }

//         // Additional data
//         $data['ad_name'] = $request->input('ad_name');
//         $data['client_name'] = $request->input('client_name');
//         $data['ad_url'] = $request->input('ad_url');
//         $data['ad_duration'] = $request->input('ad_duration');
//         $data['show_start_date'] = $request->input('show_start_date');
//         $data['show_end_date'] = $request->input('show_end_date');

//         // Update the advertising entry
//         $advertising->update($data);

//         return redirect()->route('Admin.Advertisings.index')->with('success', __('Ad updated successfully'));
//     }


//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//         $partnerSuccess = PartnerSuccess::findOrFail($id);
//         if ($partnerSuccess->image) {
//             $imagePath = public_path($partnerSuccess->image);
//             if (file_exists($imagePath)) {
//                 unlink($imagePath);
//             }
//         }

//         $partnerSuccess->delete();

//         return redirect()->route('Admin.Advertisings.index')->with('success', 'Deleted successfully');

//     }
// }



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdvertisingService;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{
    protected $service;

    public function __construct(AdvertisingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $Ads = $this->service->getAll();
        return view('Admin.Advertising.index', get_defined_vars());
    }

    public function create()
    {
        return view('Admin.Advertising.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_name' => 'required|string|max:255',
            'content' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv,flv,pdf,doc,docx|max:20480',
            'client_name' => 'nullable|string|max:255',
            'ad_url' => 'nullable|string|max:255',
            'show_start_date' => 'required|date|after_or_equal:today',
            'show_end_date' => 'required|date|after:show_start_date',
            'ad_duration' => 'required|integer|min:1',
        ]);

        $this->service->create($validated);

        return redirect()->route('Admin.Advertisings.index')->with('success', __('Ad created successfully'));
    }

    public function show($id)
    {
        $advertisement = $this->service->findById($id);
        return view('Admin.Advertising.show', compact('advertisement'));
    }

    public function edit($id)
    {
        $advertising = $this->service->findById($id);
        return view('Admin.Advertising.edit', compact('advertising'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ad_name' => 'required|string|max:255',
            'content' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv,flv,pdf,doc,docx|max:20480',
            'client_name' => 'nullable|string|max:255',
            'ad_url' => 'nullable|string|max:255',
            'show_start_date' => 'required|date|after_or_equal:today',
            'show_end_date' => 'required|date|after:show_start_date',
            'ad_duration' => 'required|integer|min:1',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('Admin.Advertisings.index')->with('success', __('Ad updated successfully'));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('Admin.Advertisings.index')->with('success', __('Ad deleted successfully'));
    }
}
