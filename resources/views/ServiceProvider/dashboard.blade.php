@extends('Admin.layouts.app')
@section('title', __('dashboard'))

@section('content')
<style>
    a.card:hover {
        /* background-color: #5c5c5c; */
        scale: 1.06 ;
        /* transition: background-color 0.3s; */
    }




.shepherd-button {
    margin: 5px; /* Add spacing between buttons */
}

</style>


    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if(auth()->user()->UserServiceProviderData->city_id && $numOfServices)
            @else
                <div>
                    <div class=" d-flex flex-column" role="alert">
                    <p>
                        <span class="alert-icon text-danger me-2">
                            <i class="ti ti-list-check ti-xs"></i>
                        </span>
                        @lang('Lets get started !..')
                    </p>

                        <ul style="list-style-type: none; padding: 0; display: flex; gap: 10px;">
                            <!-- Step 1: تحديث البيانات الشخصية -->
                            <li style="padding: 10px; border: 1px solid {{ auth()->user()->UserServiceProviderData->city_id ? 'green' : 'red' }}; border-radius: 5px;">
                                <span>
                                    @if(auth()->user()->UserServiceProviderData->city_id)
                                        <span style="color: green;">✔</span> @lang('Account data updated')
                                    @else
                                        <span style="color: red;">✖</span> @lang('Update Account data')
                                    @endif
                                </span>
                            </li>

                            <!-- Step 2: تحديث ترخيص هيئة العقار -->
                            <li style="padding: 10px; border: 1px solid {{ $numOfServices ? 'green' : 'red' }}; border-radius: 5px;">
                                <span>
                                    @if($numOfServices)
                                        <span style="color: green;">✔</span> @lang('Add Service')
                                    @else
                                        <span style="color: red;">✖</span> @lang('Add Service')
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row">

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Owner.index') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Services')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <h4 class="mb-0">{{ $numOfServices }}</h4>
                                <span class="text-success"></span>
                            </div>
                            <div class="d-flex align-items-center mt-1">

                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Tickets.index') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-ticket ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('technical support')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>

                    </a>
                </div>


            </div>


        <div class="content-backdrop fade"></div>
        </div>
    </div>


@if (\Carbon\Carbon::now()->isSameDay(\Carbon\Carbon::parse(auth()->user()->UserServiceProviderData->created_at)))
    <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1" style="text-align: center;">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title mb-4" id="backDropModalTitle">@lang('Welcome in Townapp you can strat your tour!')</h5>
                    <button type="button" class="btn btn-primary" id="startTourButton">@lang('Start Tour')</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const sectionsIds = @json($sectionsIds); // الأقسام المسموح بها للمستخدم

        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('backDropModal'), {
                keyboard: false
            });
            modal.show();

            document.getElementById('startTourButton').addEventListener('click', function () {
                modal.hide();

                let tour = new Shepherd.Tour({
                    defaultStepOptions: {
                        classes: 'shadow-md bg-white',
                        scrollTo: true,
                        cancelIcon: {
                            enabled: true
                        },
                        buttons: [
                            {
                                text: '@lang("Skip")',
                                classes: 'btn btn-secondary',
                                action: () => tour.cancel()
                            },
                            {
                                text: '@lang("Next")',
                                classes: 'btn btn-primary',
                                action: () => tour.next()
                            }
                        ]
                    },
                    useModalOverlay: true
                });

                const steps = [
                    {
                        id: 'project-management',
                        title: '@lang("project management")',
                        text: '@lang("Here you can add and view property information.")',
                        attachTo: '[data-tour="project-management"] right',
                        sectionId: 15
                    },
                    {
                        id: 'users-management',
                        title: '@lang("Users management")',
                        text: '@lang("Here you can add and view employee information.")',
                        attachTo: '[data-tour="users-management"] right',
                        sectionId: 14
                    },
                    {
                        id: 'customer-management',
                        title: '@lang("Customer Management")',
                        text: '@lang("Here you can add and view your customers information.")',
                        attachTo: '[data-tour="customer-management"] right',
                        sectionId: 19
                    },
                    {
                        id: 'contract-management',
                        title: '@lang("Contract Management")',
                        text: '@lang("Here you can add and track the status of contracts.")',
                        attachTo: '[data-tour="contract-management"] right',
                        sectionId: 30
                    },
                    {
                        id: 'financial-management',
                        title: '@lang("Financial Management")',
                        text: '@lang("Here you can manage treasuries, invoices and issue bonds.")',
                        attachTo: '[data-tour="financial-management"] right',
                        sectionId: 30
                    },
                    {
                        id: 'gallary-management',
                        title: '@lang("Gallery Management")',
                        text: '@lang("Here you can post and share real estate ads, track interest requests and property requests and view an interactive map of properties.")',
                        attachTo: '[data-tour="gallary-management"] right',
                        sectionId: 18
                    },
                    {
                        id: 'maintenance-operation-managment',
                        title: '@lang("Maintenance and Operation Management")',
                        text: '@lang("Here you can add service providers and track maintenance and operation requests.")',
                        attachTo: '[data-tour="maintenance-operation-managment"] right',
                        sectionId: 33
                    },
                    {
                        id: 'reports-and-advanced-search',
                        title: '@lang("Reports and Advanced Search")',
                        text: '@lang("Here you can access the most important reports you need with ease.")',
                        attachTo: '[data-tour="reports-and-advanced-search"] right',
                        sectionId: 34
                    },
                    {
                        id: 'subscription-management',
                        title: '@lang("Subscription Management")',
                        text: '@lang("Here you can view your current subscription information and bill or upgrade your subscription.")',
                        attachTo: '[data-tour="subscription-management"] right',
                        sectionId: 12
                    },
                    {
                        id: 'settings',
                        text: `@lang('Here you can update your account information, add your real estate license, and more settings.')`,
                        title: `@lang('Settings')`,
                        attachTo: '[data-tour="settings"] right',
                        sectionId: 11
                    },
                         //avatar

                        tour.addStep({
                            id: 'avatar-online',
                            text: `@lang('Here you can add a new account and navigate between your accounts easily.')`,
                            attachTo: {
                                element: '[data-tour="avatar-online"]',
                                on: 'right'
                            },
                            title: `@lang('Settings')`
                        }),
                          //notification

                        tour.addStep({
                            id: 'notifications',
                            text: `@lang('Here you will receive new notifications and the most important alerts.')`,
                            attachTo: {
                                element: '[data-tour="notifications"]',
                                on: 'right'
                            },
                            title: `@lang('Notifications')`
                        }),

                        //style-switcher

                        tour.addStep({
                            id: 'style-switcher',
                            text: `@lang('Here you can enable/disable dark mode.')`,
                            attachTo: {
                                element: '[data-tour="style-switcher"]',
                                on: 'right'
                            },
                            title: `@lang('style-switcher')`
                        }),


                        //language

                        tour.addStep({
                            id: 'language',
                            text: `@lang('Click here to change your account language.')`,
                            attachTo: {
                                element: '[data-tour="language"]',
                                on: 'right'
                            },
                            title: `@lang('languages')`
                        }),
                        tour.addStep({
                            id: 'search-wrapper',
                            text: `@lang('Allows searching for any keyword and displaying results matching that keyword')`,
                            attachTo: {
                                element: '[data-tour="search-wrapper"]',
                                on: 'right'
                            },
                            title: `@lang('search...')`
                        }),
                ];

                // إضافة الخطوات فقط إذا كانت موجودة في sectionsIds والعنصر موجود في DOM
                steps.forEach((step) => {
                    if (sectionsIds.includes(step.sectionId)) {
                        const element = document.querySelector(step.attachTo.split(' ')[0]);
                        if (element) {
                            tour.addStep({
                                id: step.id,
                                text: step.text,
                                attachTo: {
                                    element: step.attachTo.split(' ')[0],
                                    on: step.attachTo.split(' ')[1]
                                },
                                title: step.title
                            });
                        }
                    }
                });

                // بدء الجولة
                tour.start();
            });
        });
    </script>
@endif



@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            var numberOfUnits = {{ $numberOfUnits }};
            var numberOfVacantUnits = {{ $numberOfVacantUnits }};
            var numberOfRentedUnits = {{ $numberOfRentedUnits }};

            var vacantPercentage = 0;
            var rentedPercentage = 0;

            if (numberOfUnits > 0) {
                vacantPercentage = (numberOfVacantUnits / numberOfUnits) * 100;
                rentedPercentage = (numberOfRentedUnits / numberOfUnits) * 100;
            }else{
                vacantPercentage = 50;
                rentedPercentage = 50;;
            }

            var ctx = document.getElementById('doughnutChart').getContext('2d');
            var doughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                labels: ['Vacant', 'Rented'],
                datasets: [{
                    data: [vacantPercentage, rentedPercentage],
                    backgroundColor: [
                    'rgb(40, 208, 148)',
                    'rgb(253, 172, 52)'
                    ],
                    hoverOffset: 4
                }]
                },
                options: {
                responsive: true,
                plugins: {
                    legend: {
                    display: false
                    }
                }
                }
            });
            });
        </script>



    @endpush
@endsection
