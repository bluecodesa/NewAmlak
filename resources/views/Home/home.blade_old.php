@extends('Home.layouts.home.app')
@section('content')
    <!--end header-->
    <!-- Navbar End -->

    <!-- Start Hero -->
    <a class="dropdown-item"hidden id="pay-btnn" data-toggle="modal" data-target="#payModal">دفع</a>
    <section class="home container" id="home">
        <div class="row align-items-center mt-5 mt-sm-0">
            <div class="col-md-6">
                <div class="title-heading text-center text-md-start">
                    <div class="img-smm">
                        <img src="{{ asset('HOME_PAGE/images/new/building-_5_.png') }}" class="img-fluid" />
                    </div>
                    <h6 class="heading mb-3 mt-2 ArFont">أملاك خيارك الأول لإدارة الأملاك العقارية</h6>
                    <p class="">منصة متكاملة تخدم مدراء العقارات، والملاك، والمستأجرين</p>
                    <p class="">* التسجيل لا يتطلب بطاقة ائتمانية</p>
                    <div class="mt-4">
                        @guest
                        <a href="" class="btn btn-new ArFont" data-toggle="modal" data-target="#addSubscriberModal"
                        style="margin-right: 9px;" onclick="tabsFunc()">سجل معنا الآن</a>
                        @endguest
                        @auth
                            <a class="btn btn-new ArFont" href="{{ route('Home.Offices.CreateOffice') }}">سجل معنا الآن</a>
                        @endauth
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="freelance-hero position-relative">
                    <div class="position-relative">
                        <img src="{{ asset('HOME_PAGE/images/new/Group104105.png') }}" class="mx-auto d-block img-fluid"
                            alt=""
                            style="height: auto;
                            width: 100%;
                            border-radius: 49px;
                            object-fit: cover;">

                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <!--end container-->
    </section>
    <!--end section-->
    <!-- End Hero -->


    <!-- Start -->
    <section class="system container">
        <div class="row align-items-center">
            <div class="sec-title">
                <h4>أملاك نظام إدارة متطور</h4>
                <p>حلول تقنية متطورة تلبي جميع أعمالك</p>
            </div>
            <div class="row-cols">
                <div class="row">
                    <div class="col-md-3 system-col">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/Group104104.png') }}" height="50"
                                class="logo-light-mode  fixed-img" alt="">
                            <img src="{{ asset('HOME_PAGE/images/new/seo-and-web.png') }}" height="50"
                                class="logo-light-mode  hover-img" alt="">
                        </div>
                        <div class="content">
                            <h5>علاقات العملاء</h5>
                            <p>من خلال منصة مخصصة لعملائك تستطيع استقبال طلبات الصيانة والشكاوى</p>
                        </div>
                    </div>

                    <div class="col-md-3 system-col">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/project-management-_2_.png') }}" height="50"
                                class="logo-light-mode fixed-img" alt="">
                            <img src="{{ asset('HOME_PAGE/images/new/pp.png') }}" height="50"
                                class="logo-light-mode  hover-img" alt="">
                        </div>
                        <div class="content">
                            <h5>التنبيهات للعقود</h5>
                            <p>من خلال لوحة التحكم الخاصة بك يمكنك متابعة جميع عقود عملائك ومعرفة عدد الأيام
                                المتبقية لانتهاء العقد</p>
                        </div>
                    </div>

                    <div class="col-md-3 system-col">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/home-_2_.png') }}" height="50"
                                class="logo-light-mode fixed-img" alt="">
                            <img src="{{ asset('HOME_PAGE/images/new/444.png') }}" height="50"
                                class="logo-light-mode  hover-img" alt="">
                        </div>
                        <div class="content">
                            <h5>ملفات مشتركة</h5>
                            <p>من خلال النظام يمكنكم مشاركة وتبادل الملفات وحفظها واسترجاعها عند الحاجة.</p>
                        </div>
                    </div>

                    <div class="col-md-3 system-col">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/house.png') }}" height="50"
                                class="logo-light-mode fixed-img" alt="">
                            <img src="{{ asset('HOME_PAGE/images/new/11111.png') }}" height="50"
                                class="logo-light-mode hover-img" alt="">
                        </div>
                        <div class="content">
                            <h5>دعم فني متقدم 24/7</h5>
                            <p>تقدم أملاك دعم فني متقدم خلال 24/7 لجميع التحديات التقنية التي تواجه أعمالك.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end row-->
        <!--end container-->
    </section>

    <section class="promotion container">
        <div class="promo-details">
            <div class="row">
                <div class="col-md-8">
                    <h4>ماذا تنتظر !؟</h4>
                    <h4>انضم لنا الآن</h4>
                    <p>واجهة سهلة الإستخدام بمميزات متعددة</p>
                </div>
                <div class="col-md-4">
                    @guest
                        <a href="" class="btn btn-new ArFont" data-toggle="modal" data-target="#addSubscriberModal"
                        style="margin-right: 9px;" onclick="tabsFunc()">سجل معنا الآن</a>
                        @endguest
                    @auth
                        <a class="btn btn-new-b ArFont" href="">سجل معنا الآن</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>


    <section class="features container" id="features">
        <div class="container">
            <div class="row align-items-center">
                <div class="sec-title">
                    <h4>مميزات أملاك</h4>
                    <p>تم تصميم نظام أملاك وفق خطوات مدروسة بعناية ليوفر أعلى درجات الاحترافية في إدارة متطلبات القطاع
                        العقاري</p>
                </div>
            </div>

            <div class="features-container">
                <div class="row text-first">
                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm">
                                <img src="{{ asset('HOME_PAGE/images/new/dashboard-_3_.png') }}" class="img-fluid" />
                            </div>
                            <h4>لوحة تحكم سهلة الإستخدام</h4>
                            <p>يقدم لك نظام أملاك أفضل الطرق الاحترافية لإدارة علاقات العملاء من خلال استقبال طلبات
                                الصيانة والشكاوى من المنصة ومعرفة حالة الطلب لدي العميل من غير التواصل معه بشكل مباشر
                                .</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/4.png') }}" class="img-fluid" />
                        </div>
                    </div>
                </div>

                <div class="row img-first">
                    <div class="col-md-6">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/Group103411.png') }}" class="img-fluid" />

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm-y">
                                <img src="{{ asset('HOME_PAGE/images/new/contract-_1_.png') }}" class="img-fluid" />
                            </div>
                            <h4>إدارة عقود عملائك بشكل محكم</h4>
                            <p>تستطيع إضافة عقد لكل عميل بطريقة سريعه جداًً مع إمكانية تعديل عمولة المكتب لكل عقد وإضافة
                                مصاريف الخدمات الأخرى أيضاً حسب الحاجة.</p>
                        </div>
                    </div>

                </div>

                <div class="row text-first">
                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm">
                                <img src="{{ asset('HOME_PAGE/images/new/building-_5_.png') }}" class="img-fluid" />
                            </div>
                            <h4>إدارة المشاريع بكل تفاصيلها</h4>
                            <p>يتيح لك نظام أملاك إضافة كافة تفاصيل مشاريعك على جميع المستويات حتى العقارات و الوحدات
                                أيضاً.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/3.png') }}" class="img-fluid" />

                        </div>
                    </div>
                </div>

                <div class="row img-first">
                    <div class="col-md-6">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/2.png') }}" class="img-fluid " />

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm-y">
                                <img src="{{ asset('HOME_PAGE/images/new/real-estate-agent.png') }}" class="img-fluid" />
                            </div>
                            <h4>إدارة مستخدمي للنظام</h4>
                            <p>تستطيع إضافة مستخدم/موظف جديد ومنحه الصلاحيات المطلوبة حسب حاجة العمل.</p>
                        </div>
                    </div>

                </div>

                <div class="row text-first">

                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm">
                                <img src="{{ asset('HOME_PAGE/images/new/real-estate-agent.png') }}" class="img-fluid" />
                            </div>
                            <h4>إدارة علاقات العملاء</h4>
                            <p>يقدم لك نظام أملاك أفضل الطرق الاحترافية لإدارة علاقات العملاء من خلال استقبال طلبات
                                الصيانة والشكاوى من المنصة ومعرفة حالة الطلب دون الحاجة إلى التواصل مع العملاء بشكل
                                مباشر.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/edara.png') }}" class="img-fluid" />

                        </div>
                    </div>

                </div>

                <div class="row img-first">
                    <div class="col-md-6">
                        <div class="img soon">
                            <img src="{{ asset('HOME_PAGE/images/new/5.png') }}" class="img-fluid " />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm">
                                <img src="{{ asset('HOME_PAGE/images/new/dashboard-_3_.png') }}" class="img-fluid" />
                            </div>
                            <h4>إدارة التنبيهات</h4>
                            <p>يقدم لك نظام أملاك خيارات مختلفة لإرسال الإشعارات ورسائل التذكير التلقائية لعملائك عبر
                                خدمة الواتس اب أو البريد الإلكتروني أو ال SMS.</p>
                        </div>
                    </div>

                </div>

                <div class="row img-first">

                    <div class="col-md-6">
                        <div class="content">
                            <div class="img-smm-y">
                                <img src="{{ asset('HOME_PAGE/images/new/Group103560.png') }}" class="img-fluid" />
                            </div>
                            <h4>شارك عروض التأجير مع عملائك</h4>
                            <p>من خلال منصة أملاك تستطيع إعداد عروض التأجير ومشاركتها مع عملائك المحتملين بطريقة
                                احترافية و تفصيلية.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img soon">
                            <img src="{{ asset('HOME_PAGE/images/new/gghh.png') }}" class="img-fluid " />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    @guest
    <section class="pricing container" id="pricing">
        <div class="row align-items-center">
            <div class="sec-title">
                <h4>باقات وأسعار أملاك</h4>
                <p>توفر لكم منصة أملاك باقات مميزة تمكنك من إدارة المستأجرين بكل سهولة</p>
            </div>
        </div>

        <div class="pricing-container desktop">
            <div style="border: 1px solid #e3e1e1; padding: 0px 12px; border-radius: 41px; width: 100%;">
                <div class="row first-fix">
                    <div class="col-3" style="padding-top: 50px;">
                        <h5 style="font-size: 28px!important; font-weight: 900!important; line-height: 1.50em;">
                            ابدأ معنا الآن
                            <br />واختر خطتك !
                        </h5>
                        <p>الدفع سنوياً <span style="color: #497AAC">(خصم يصل إلى 30%)</span></p>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check form-switch">
                                    <div class="check">
                                        <div class="check1 active-check" onclick="changePeriod(1)">شهري</div>
                                        <div class="check2" onclick="changePeriod(2)">سنوي</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($sections as $section)
                            <div class="row" style="background-color:#F6F9FC ;">
                                <div class="col-3">
                                    <p>{{ $section->name }}</p>
                                    <p>{{ $section->description}}</p>

                                </div>
                            </div>
                            @endforeach
                    </div>
                    @foreach ($subscriptionTypes as $subscriptionType)
                    <div class="col-3 center-price" style="padding-top: 50px;border-right: 1px solid #e3e1e1;">
                        <div class="img-smm-y" style="margin: auto;background-color: #497aac;">
                            <img src="{{ asset('HOME_PAGE/images/new/free.png') }}" class="img-fluid" />
                        </div>
                        <h5>{{ $subscriptionType->name }}</h5>
                        <p>
                            @foreach ($subscriptionType->roles as $role)
                                <span> اشتراك   {{ $role->name_ar }}</span>
                            @endforeach
                        </p>

                        <p><span class="yel-price">{{ $subscriptionType->price }}</span> رس</p>
                        @if ($subscriptionType && $subscriptionType->roles->count() == 2)
                        <div class="col-3 center-price" >
                            <a class="btn btn-new2 ArFont" href="" data-toggle="modal" data-target="#addSubscriberModal"
                                style="margin-right: 9px;" onclick="tabsFunc()">ابدأ الآن</a>
                        </div>
                        @elseif ($role->name == "RS-Broker" )
                        <div class="col-3 center-price">
                            <a class="btn btn-new2 ArFont" data-toggle="modal"
                             onclick="redirectToCreateBroker()">ابدأ الآن</a>

                        </div>
                        @elseif( $role->name == "Office-Admin" )
                        <div class="col-3 center-price">
                            <a class="btn btn-new2 ArFont" data-toggle="modal"
                             onclick="redirectToCreateOffice()">ابدأ الآن</a>

                        </div>


                       @endif

                        <div class="col-12">
                            @foreach ($sections as $section)
                            <div class="row" style="background-color:#F6F9FC ;">
                                {{-- <div class="col-3">
                                    <p>{{ $section->name }}</p>
                                </div> --}}
                                <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                                    @if ($subscriptionType->SectionData->contains('section_id', $section->id))
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                            style="width: 20px; fill: #497aac;">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                        </svg>
                                    </p>
                                    @else
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 20px; fill: #ff0000;">
                                            <path d="M12 2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10zm5 11h-10v-2h10v2z"/>
                                        </svg>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
    </section>
    @endguest

    @auth
    <section class="pricing container" id="pricing">
        <div class="row align-items-center">
            <div class="sec-title">
                <h4>باقات وأسعار أملاك</h4>
                <p>توفر لكم منصة أملاك باقات مميزة تمكنك من إدارة المستأجرين بكل سهولة</p>
            </div>
        </div>

        <div class="pricing-container desktop">
            <div style="border: 1px solid #e3e1e1; padding: 0px 12px; border-radius: 41px; width: 100%;">
                <div class="row first-fix">
                    <div class="col-3" style="padding-top: 50px;">
                        <h5 style="font-size: 28px!important; font-weight: 900!important; line-height: 1.50em;">
                            ابدأ معنا الآن
                            <br />واختر خطتك !
                        </h5>
                        <p>الدفع سنوياً <span style="color: #497AAC">(خصم يصل إلى 30%)</span></p>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check form-switch">
                                    <div class="check">
                                        <div class="check1 active-check" onclick="changePeriod(1)">شهري</div>
                                        <div class="check2" onclick="changePeriod(2)">سنوي</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($sections as $section)
                        <div class="row" style="background-color:#F6F9FC;">
                            <div class="text-container">
                                <p>{{ $section->name }}</p>
                                <span style="font-size: smaller;">{{ $section->description }}</span>
                            </div>
                        </div>
                    @endforeach

                    </div>
                    @foreach ($subscriptionTypesRoles as $subscriptionType)
                    <div class="col-3 center-price" style="padding-top: 50px;border-right: 1px solid #e3e1e1;">
                        <div class="img-smm-y" style="margin: auto;background-color: #497aac;">
                            <img src="{{ asset('HOME_PAGE/images/new/free.png') }}" class="img-fluid" />
                        </div>
                        <h5>{{ $subscriptionType->name }}</h5>
                        <p><span class="yel-price">{{ $subscriptionType->price }}</span> رس</p>
                        <div class="col-3 center-price">


                            <a class="btn btn-new2 ArFont" href="{{ route('Admin.home') }}">ابدأ الآن</a>

                        </div>


                        <div class="col-12">
                            @foreach ($sections as $section)
                            <div class="row" style="background-color:#F6F9FC ;">
                                {{-- <div class="col-3">
                                    <p>{{ $section->name }}</p>
                                </div> --}}
                                <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                                    @if ($subscriptionType->SectionData->contains('section_id', $section->id))
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                            style="width: 20px; fill: #497aac;">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                        </svg>
                                    </p>
                                    @else
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 20px; fill: #ff0000;">
                                            <path d="M12 2c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10zm5 11h-10v-2h10v2z"/>
                                        </svg>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
    </section>
    @endauth


    <section class="services container">
        <div class="container">
            <div class="row align-items-center">
                <div class="sec-title">
                    <h4>خدمات أملاك</h4>
                    <p>نحرص على تطوير خدمات تقنية متميزة واحترافية تساهم في تبسيط ادارة اعمالك العقارية، كما تضمن املاك سرية
                        وتوافرية بياناتك بشكل دائم عبر استخدام احدث التقنيات المبتكرة.</p>
                </div>
            </div>

            <div class="services-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="img">
                            <img src="{{ asset('HOME_PAGE/images/new/mockup.png') }}" alt="" class="img-fluid">

                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 20px">




                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <span class="yel-price">
                                نظام أملاك
                            </span>
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <div class="service-content">

                                        <h5>إدارة الملاك و المستأجرين</h5>
                                        <p>إدارة كاملة للملاك، و دعم جميع تفاصيل المشروعات العقارية على مستوى العقارات
                                            والوحدات </p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="service-content">

                                        <h5>إدارة المستأجرين</h5>
                                        <p>إدارة كاملة للمستأجرين، و دعم جميع تفاصيل المشروعات العقارية على مستوى
                                            العقارات والوحدات </p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="service-content">
                                        <h5>إضافة تفاصيل العقارات والوحدات</h5>
                                        <p>يمكنك إضافة كافة التفاصيل المتعلقة بالعقار أو الوحدة </p>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="service-content">
                                        <h5>طريقة مبتكرة لمتابعة تحصيل الإيجارات وأقساط البيع</h5>
                                        <p>يمكنك متابعة حالة العقد و الدفعات المستحقة لكل عميل كما يوفر النظام طرق
                                            مختلفة للسداد و استعراض الفواتير وإيصالات الدفع </p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="promotion container">
        <div class="promo-details">
            <div class="row">
                <div class="col-md-8">
                    <h4>ماذا تنتظر !؟</h4>
                    <h4>انضم إلى أملاك الآن</h4>
                    <p>واجهة سهلة الإستخدام بمميزات متعددة</p>
                </div>
                <div class="col-md-4">
                    @guest
                    <a href="" class="btn btn-new ArFont" data-toggle="modal" data-target="#addSubscriberModal"
                    style="margin-right: 9px;" onclick="tabsFunc()">سجل معنا الآن</a>
                    @endguest
                    @auth
                        <a class="btn btn-new-b ArFont" href="">سجل معنا الآن</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section class="faq container">
        <div class="row align-items-center">
            <div class="sec-title">
                <h4>الأسئلة الشائعة</h4>
                <p>لديك سؤال!؟ تحقق من هذه الأجوبة</p>
            </div>
        </div>
        <div class="faq-container">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            ما هي منصة أملاك؟ </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            هي منصة إلكترونية تم تصميمها بإتقان لتوفير حلول متكاملة لجميع الخدمات العقارية بطريقة سهلة
                            وشاملة لكافة المهام والإجراءات الخاصة بالمكاتب العقارية و إدارة العقارات والوحدات السكنية
                            والتجارية على السواء. تهدف أملاك إلى إدارة جميع مستويات المشروعات العقارية بدءا من الوحدات
                            وصولا إلى المشروعات عبر نظام متطور وحلول تقنية مبتكرة تهدف إلى القيام بجميع الاعمال عن بعد
                            بجودة وموثوقية عالية، عبر استقطاب العديد من الخبرات الإدارية و التسويقية والمحاسبية ذات
                            الكفاءة العالية.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            ما هي خطط الأسعار المتاحة للاشتراك في منصة أملاك؟</button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            توفر منصة أملاك مجموعة متنوعة من خطط الأسعار لتناسب منشأتك بشكل متكامل وتلبي جميع الخدمات
                            التي تحتاجها.
                            <ul style="list-style:none">
                                <li>- اشتراك مجاني (فترة تجريبية)</li>
                                <li>- اشتراك شهري</li>
                                <li>- اشتراك سنوي (قريبا)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            ما هي الاجراءات اللازمة للتسجيل على منصة أملاك؟
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            للتسجيل و الانضمام إلى نظام أملاك يجب مليء فورم التسجيل عبر الضغط على زر "سجل معنا الآن" و
                            ادخال بيانات شركتك:
                            <ul style="list-style:none;">
                                <li>-اسم الشركة</li>
                                <li>-البريد الإلكتروني</li>
                                <li>-شعار الشركة</li>
                                <li>-اسم ورقم هاتف ممثل الشركة</li>
                                <li>-اختيار نوع الاشتراك في النظام</li>
                            </ul>
                            بعد ذلك سوف يكون حسابك جاهزاً لتبدأ تجربة متميزة ومبتكرة لإدارة مشروعك العقاري.

                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFour" aria-expanded="false"
                            aria-controls="flush-collapseFour">
                            ماذا أفعل عندما تواجهني مشكلة أثناء استخدامي لمنصة أملاك؟ </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            عندما تواجهك مشكلة أو إذا كان لديك شكوى أو اقتراحات يمكنك فتح تذكرة دعم فني بسهولة من خلال
                            حسابك على المنصة و سوف يصلك الرد من فريق الدعم في اسرع وقت.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="clients container">
        <div class="row align-items-center">
            <div class="sec-title">
                <h4>شركاء النجاح</h4>
                <p>نتشرف بثقة و دعم العديد من المؤسسات حول المملكة</p>
            </div>
        </div>


        <div class="clients-container">
            <div class="container text-center my-3">
                <div class="row mx-auto my-auto justify-content-center">
                    <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/1.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/2.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/3.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/4.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/5.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/6.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="{{ asset('HOME_PAGE/images/new/partners/7.png') }}" alt=""
                                                class="img-fluid kenan" style="width:100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>



{{-- تجربه الباقات  --}}
<section class="pricing container" id="pricing">
    <div class="row align-items-center">
        <div class="sec-title">
            <h4>باقات وأسعار أملاك</h4>
            <p>توفر لكم منصة أملاك باقات مميزة تمكنك من إدارة المستأجرين بكل سهولة</p>
        </div>
    </div>

    <div class="pricing-container desktop">
        <div style="border: 1px solid #e3e1e1; padding: 0px 12px; border-radius: 41px; width: 100%;">
            <div class="row first-fix">
                <div class="col-3" style="padding-top: 50px;">
                    <h5 style="font-size: 28px!important; font-weight: 900!important; line-height: 1.50em;">
                        ابدأ معنا الآن
                        <br>واختر خطتك !
                    </h5>
                    <p style="padding:0px !important;">الدفع شهريآ <span style="color: #f90622;">(خصم حصري 50%)</span>
                    </p>
                    <p style="padding:0px !important;">الدفع سنوياً <span style="color: #497AAC;">(خصم يصل إلى
                            13%)</span></p>
                            <div class="col-3 center-price">
                                <a class="btn btn-new2 ArFont" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter">ابدأ الآن</a>
                                                </div>
                            @foreach ($sections as $section)

                            <div class="col-12">
                                <p>{{ $section->name }}</p>
                                <p>{{ $section->description}}</p>                            </div>
                            @endforeach
                </div>
                @foreach ($subscriptionTypes as $subscriptionType)

                <div class="col-3 center-price" style="padding-top: 50px;border-right: 1px solid #e3e1e1;">
                    <div class="img-smm-y" style="margin: auto;background-color: #497aac;">
                        <img src="https://tryamlak.com/HOME_PAGE/images/new/free.png" class="img-fluid">
                    </div>
                    <h5>مجانية</h5>
                    <p><span class="yel-price">0</span> رس </p>
                    <div class="col-3 center-price" style="align-content: center">
                        <a class="btn btn-new2 ArFont" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter">ابدأ الآن</a>
                                        </div>
                                        @foreach ($sections as $section)

                            <div class="col-3">
                                <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px;
                                    fill: #497aac;">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"></path>
                                        </svg>
                                    </p>

                                </div>
                                <div class="col-3">
                                    <p>
                                        </p>

                                    </div>
                            @endforeach
                </div>


                @endforeach


            </div>

    </div>
</section>
    <!-- Footer Start -->


    <!-- Modal -->


        <script>
            window.onload = function() {
                document.querySelector('a#pay-btnn').click();

            }
        </script>
        <style>
            .modal.show .modal-dialog {
                width: 58%;
                transform: none;
                top: 4%;
                max-width: initial;
                margin-bottom: 50px;
            }

            .details.row {
                border: 2px solid #F5D566C7;
                border-radius: 17px;
                padding: 10px;
                margin: auto;
            }

            button.btn.btn-primary.modal-submit {
                background: #497AAC 0% 0% no-repeat padding-box;
                box-shadow: 0px 8px 20px #91C0E973;
                border-radius: 9px;
                line-height: 1.8em;
                width: 100%;
            }

            .modal-dialog p,
            .modal-dialog span,
            .modal-dialog strong {
                color: #2B3641
            }

        </style>



    <!--end footer-->
    <!-- Footer End -->
    <style>.zsiq_theme1.zsiq_floatmain {

    display: none!important;
}</style>

    @push('home-scripts')
 <script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "siqf8adecbae539f10442e3263a1c7449fe02f8434ebbe72fa0f7a759edb7870245", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zohopublic.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>

    @endpush

<!--add new subscribers-->
@include('Home.layouts.inc.__addSubscriberModal')
<script>
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }
    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }
</script>

{{-- <script>
    // Get all elements with the class 'center-price'
    var subscriptionTypeDivs = document.querySelectorAll(".center-price");

    // Add click event listener to each element
    subscriptionTypeDivs.forEach(function(element) {
        element.addEventListener("click", function() {
            // Remove 'custom-grad' class from all elements
            subscriptionTypeDivs.forEach(function(el) {
                el.classList.remove("custom-grad");
            });
            // Toggle 'custom-grad' class on the clicked element
            this.classList.toggle("custom-grad");
        });
    });
</script> --}}




@endsection
