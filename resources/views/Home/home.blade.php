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
                            <a class="btn btn-new ArFont" href="javascript:void(0)" data-toggle="modal" onclick="tabsFunc()"
                                data-target="#exampleModalCenter" id="open-poop">سجل معنا الآن</a>
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
                        <a class="btn btn-new-b ArFont" href="javascript:void(0)" data-toggle="modal" onclick="tabsFunc()"
                            data-target="#exampleModalCenter">سجل معنا الآن</a>
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
                    </div>
                    <div class="col-3 center-price" style="padding-top: 50px;border-right: 1px solid #e3e1e1;">
                        <div class="img-smm-y" style="margin: auto;background-color: #497aac;">
                            <img src="{{ asset('HOME_PAGE/images/new/free.png') }}" class="img-fluid" />
                        </div>
                        <h5>مجانية</h5>
                        <p><span class="yel-price">0</span> رس </p>
                    </div>
                    <div class="col-3 custom-grad"
                        style="border-top-right-radius: 41px;padding-top: 50px; border-top-left-radius: 41px;">
                        <div class="img-smm-y" style="margin: auto;background-color: #fff;">
                            <img src="{{ asset('HOME_PAGE/images/new/Star.png') }}" class="img-fluid" />
                        </div>
                        <h5>شهرية</h5>
                        <p class="change_period first"><span class="yel-price">49</span><span class="month"> رس /
                                شهريا</span></p>
                    </div>
                    <div class="col-3 center-price soooon" style="padding-top: 50px; ">
                        <div class="soon-feature">
                            <div class="img-smm-y" style="margin: auto">
                                <img src="{{ asset('HOME_PAGE/images/new/medal.png') }}" class="img-fluid" />
                            </div>
                            <h5>سنوية</h5>
                            <p class="change_period second"><span class="yel-price">?</span><span class="month"> رس
                                    /
                                    شهريا</span></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="form-check form-switch">
                            <div class="check">
                                <div class="check1 active-check" onclick="changePeriod(1)">شهري</div>
                                <div class="check2" onclick="changePeriod(2)">سنوي</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 center-price" style="padding-bottom: 30px;border-right: 1px solid #e3e1e1;">
                        @guest
                            <a class="btn btn-new2 ArFont" href="javascript:void(0)" data-toggle="modal"
                                data-target="#exampleModalCenter">ابدأ الآن</a>
                        @endguest
                        @auth
                            <a class="btn btn-new2 ArFont" href="">ابدأ الآن</a>
                        @endauth
                    </div>
                    <div class="col-3 custom-grad" style="padding-bottom: 30px">
                        @guest
                            <a class="btn btn-new-b ArFont" href="javascript:void(0)" data-toggle="modal"
                                data-target="#exampleModalCenter">ابدأ الآن</a>
                        @endguest
                        @auth
                            <a class="btn btn-new-b ArFont" href="">ابدأ الآن</a>
                        @endauth
                    </div>
                    <div class="col-3 center-price soon-feature"
                        style="padding-bottom: 30px ;border-left: 1px solid #e3e1e1;">
                        <a class="btn  ArFont" disabled
                            style=" border: 1px solid #497aac;color: #060D07;  border-radius: 25px; background-color: #fff;    cursor: auto;">ابدأ
                            الآن</a>
                    </div>
                </div>
                <div class="row" style="background-color:#F6F9FC ;">
                    <div class="col-3">
                        <p>مدة الاشتراك</p>
                    </div>
                    <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                        <p>اسبوع</p>
                    </div>
                    <div class="col-3 custom-grad">
                        <p>شهر</p>
                    </div>
                    <div class="col-3 center-price soon-feature" style="border-left: 1px solid #e3e1e1;">
                        <p>12 شهر </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <p>عدد لا محدود من ملاك العقارات</p>
                    </div>
                    <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">


                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                        fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>
                    <div class="col-3 custom-grad">
                        <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                        </p>
                    </div>
                    <div class="col-3 center-price soon-feature">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>

                </div>
                <div class="row" style="background-color:#F6F9FC">
                    <div class="col-3">
                        <p>عدد لا محدود من العقارات</p>
                    </div>
                    <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>
                    <div class="col-3 custom-grad">
                        <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                        </p>
                    </div>
                    <div class="col-3 center-price soon-feature">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-3">
                        <p>عدد لا محدود من العملاء</p>
                    </div>
                    <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>
                    <div class="col-3 custom-grad">
                        <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                        </p>
                    </div>
                    <div class="col-3 center-price soon-feature">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>

                </div>
                <div class="row" style="background-color:#F6F9FC ;">
                    <div class="col-3">
                        <p>عدد لا محدود من العقود</p>
                    </div>
                    <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>
                    <div class="col-3 custom-grad">
                        <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                        </p>
                    </div>
                    <div class="col-3 center-price soon-feature">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-3">
                        <p>عدد لا محدود من المستخدمين</p>
                    </div>
                    <div class="col-3 center-price" style="border-right: 1px solid #e3e1e1;">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>
                    <div class="col-3 custom-grad"
                        style="border-bottom-left-radius: 41px;
                border-bottom-right-radius: 41px;">
                        <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                        </p>
                    </div>
                    <div class="col-3 center-price soon-feature">
                        <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                style="width: 20px;
                    fill: #497aac;">
                                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                            </svg>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="pricing-container mobile">
            <div class="row">
                <div class="col-12" style="padding-top: 5px;">
                    <h5
                        style="font-size: 28px!important;
                    font-weight: 900!important;
                    line-height: 1.50em;">
                        ابدأ معنا الآن
                        واختر خطتك !
                    </h5>
                    <p>الدفع سنوياً <span style="color: #497AAC">(خصم يصل إلى 30%)</span></p>
                    <div class="form-check form-switch">
                        <div class="check">
                            <div class="check1 active-check">شهري</div>
                            <div class="check2">سنوي</div>
                        </div>
                    </div>
                </div>
                <div class="col-4 center-price" style="padding-top: 30px;">
                    <div class="img-smm-y" style="margin: auto;background-color: #497aac;">
                        <img src="{{ asset('HOME_PAGE/images/new/free.png') }}" class="img-fluid" />
                    </div>
                    <h5>مجانية</h5>
                    <p><span class="yel-price">0</span> رس / شهريا</p>
                </div>
                <div class="col-4 custom-grad"
                    style="border-top-right-radius: 41px;padding-top: 30px;
                border-top-left-radius: 41px;">
                    <div class="img-smm-y" style="margin: auto;background-color: #fff;">
                        <img src="{{ asset('HOME_PAGE/images/new/Star.png') }}" class="img-fluid" />
                    </div>
                    <h5>شهرية</h5>
                    <p><span class="yel-price">49</span> رس / شهريا</p>
                </div>
                <div class="col-4 center-price soooon" style="padding-top: 30px;">
                    <div class="soon-feature">
                        <div class="img-smm-y" style="margin: auto">
                            <img src="{{ asset('HOME_PAGE/images/new/medal.png') }}" class="img-fluid" />
                        </div>
                        <h5>سنوية</h5>
                        <p><span class="yel-price">؟</span> رس / شهريا</p>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-4 center-price" style="padding-bottom: 30px">
                    @guest
                        <a class="btn btn-new2 ArFont" href="javascript:void(0)" data-toggle="modal"
                            data-target="#exampleModalCenter">ابدأ الآن</a>
                    @endguest
                    @auth
                        <a class="btn btn-new2 ArFont" href="">ابدأ الآن</a>
                    @endauth
                </div>
                <div class="col-4 custom-grad" style="padding-bottom: 30px">
                    @guest
                        <a class="btn btn-new2 ArFont" href="javascript:void(0)" data-toggle="modal"
                            data-target="#exampleModalCenter">ابدأ الآن</a>
                    @endguest
                    @auth
                        <a class="btn btn-new2 ArFont" href="">ابدأ الآن</a>
                    @endauth
                </div>
                <div class="col-4 center-price soon-feature" style="padding-bottom: 30px">
                    <a class="btn ArFont" disabled
                        style="    border: 1px solid #497aac;
    color: #060D07;
    border-radius: 25px;
    background-color: #fff;    cursor: auto;    min-width: fit-content;
    padding: 0 11px;
    min-height: 40px;
    margin: auto;
    border-radius: 12px;">ابدأ
                        الآن</a>
                </div>
            </div>
            <div class="col-12">
                <p>مدة الاشتراك</p>
            </div>
            <div class="row" style="background-color:#F6F9FC">
                <div class="col-4 center-price">
                    <p>اسبوع</p>
                </div>
                <div class="col-4 custom-grad">
                    <p>شهر</p>
                </div>
                <div class="col-4 center-price soon-feature">
                    <p>12 شهر </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p>عدد لا محدود من ملاك العقارات</p>
                </div>
                <div class="col-4 center-price">


                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                        fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>
                <div class="col-4 custom-grad">
                    <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                    </p>
                </div>
                <div class="col-4 center-price soon-feature">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>

            </div>
            <div class="row" style="background-color:#F6F9FC">
                <div class="col-12">
                    <p>عدد لا محدود من العقارات</p>
                </div>
                <div class="col-4 center-price">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>
                <div class="col-4 custom-grad">
                    <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                    </p>
                </div>
                <div class="col-4 center-price soon-feature">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <p>عدد لا محدود من العملاء</p>
                </div>
                <div class="col-4 center-price">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>
                <div class="col-4 custom-grad">
                    <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                    </p>
                </div>
                <div class="col-4 center-price soon-feature">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>

            </div>
            <div class="row" style="background-color:#F6F9FC">
                <div class="col-12">
                    <p>عدد لا محدود من العقود</p>
                </div>
                <div class="col-4 center-price">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>
                <div class="col-4 custom-grad">
                    <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                    </p>
                </div>
                <div class="col-4 center-price soon-feature">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <p>عدد لا محدود من المستخدمين</p>
                </div>
                <div class="col-4 center-price">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>
                <div class="col-4 custom-grad"
                    style="border-bottom-left-radius: 41px;
                border-bottom-right-radius: 41px;">
                    <p><img src="{{ asset('HOME_PAGE/images/new/check.png') }}" alt="">
                    </p>
                </div>
                <div class="col-4 center-price soon-feature">
                    <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            style="width: 20px;
                    fill: #497aac;">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                        </svg>
                    </p>
                </div>

            </div>

        </div>
    </section>



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
                        <a class="btn btn-new-b ArFont" href="javascript:void(0)" data-toggle="modal" onclick="tabsFunc()"
                            data-target="#exampleModalCenter">سجل معنا الآن</a>
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


    <!-- Footer Start -->
  <footer class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6  col-12 mb-0 mb-md-4 pb-0 pb-md-2 first">
                    <a href="#" class="logo-footer">
                        <img src="https://tryamlak.com/HOME_PAGE/images/amlak1.svg" height="40" alt="">
                    </a>
                    <p>خيارك الأول لإدارة العقارات عبر منصة متكاملة تخدم مدراء العقارات، والملاك والمستأجرين</p>
                    <div class="sub">
                        <h5>سجل معنا ليصلك كل جديد</h5>
                        <form siq_id="autopick_9535">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="foot-subscribe foot-white mb-3">

                                        <div class="form-icon position-relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fea icon-sm icons"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                            <input type="email" name="email" id="emailsubscribe" class="form-control bg-light border ps-5 rounded ArFont" placeholder="ادخل بريدك الالكتروني" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="d-grid">
                                        <input type="submit" id="submitsubscribe" name="send" class="btn btn-new ArFont" value="تسجيل">
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </form>
                    </div>
                </div>
                <!--end col-->

                <div class="col-lg-2 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0 second">
                    <h5 class="text-dark footer-head">عن بلوكود</h5>
                    <ul class="list-unstyled footer-list mt-4">
                        <li><a href="https://bluecode.sa/about" target="_blank">من نحن</a></li>
                        <li><a href="https://bluecode.sa/services" target="_blank">خدماتنا</a></li>
                        <li><a href="https://bluecode.sa/products" target="_blank">منتجاتنا</a></li>
                        <li><a href="https://bluecode.sa/projects" target="_blank">مشاريعنا</a></li>
                    </ul>
                </div>
                <!--end col-->

                <div class="col-lg-2 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0 third">
                    <h5 class="text-dark footer-head ArFont">روابط مهمة</h5>
                    <ul class="list-unstyled footer-list mt-4">
                        <li><a href="#">الشروط
                                والاحكام
                            </a></li>
                        <li><a href="#">
                                سياسة الخصوصية</a></li>
                        <li><a href="#">
                                ملفات التوثيق</a></li>
                    </ul>
                </div>
                <!--end col-->

                <div class="col-lg-3 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0 fourth">
                    <h5 class="text-dark footer-head ArFont">تواصل معنا</h5>
                    <ul class="list-unstyled footer-list mt-4" style="list-style: none;padding-right: 0px!important;">
                        <li><a href="#" class="d-flex">
                                <div class="img-smm-div">
                                    <img src="https://tryamlak.com/HOME_PAGE/images/new/Location.png" class="img-fluid">
                                </div>

                                المملكة العربية السعودية
                                <br>
                                (الرياض - جدة - الدمام)
                            </a></li>
                        <li><a href="mailto:hi@bluecode.sa">
                                <div class="img-smm-div">
                                    <img src="https://tryamlak.com/HOME_PAGE/images/new/Iconly-Bold-Message.png" class="img-fluid">
                                </div>
                                hi@bluecode.sa
                            </a></li>
                        <li><a href="tel:+966500334691">
                                <div class="img-smm-div">
                                    <img src="https://tryamlak.com/HOME_PAGE/images/new/Iconly-Bold-Call.png" class="img-fluid">
                                </div>
                                <p style="direction: ltr;display: inline-block;">+966 50 033 4691</p>
                            </a></li>

                        <li><a href="https://twitter.com/tryamlak" target="_blank">
                                <div class="img-smm-div">
                                    <img src="https://tryamlak.com/HOME_PAGE/images/new/icons8-twitter-48.png" class="img-fluid">
                                </div>
                                <p style="direction: ltr;display: inline-block;">@tryamlak</p>
                            </a></li>
                    </ul>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </footer>

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
<div class="modal fade" id="addSubscriberModal" tabindex="-1" role="dialog"
    aria-labelledby="addSubscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="addSubscriberModalLabel"></h5> --}}
                <p style="text-align: center;font-weight: 900; margin-bottom: 25px;">
                    نوع الحساب</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-deck">
                    <!-- Add New Office Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row account_row">
                                    <div class="col-sm-12 col-md-6 account_type next-step" onclick="redirectToCreateOffice()">
                                        <div class="img-smm">
                                            <img src="{{ asset('HOME_PAGE/images/new/building-_5_.png') }}"
                                                class="img-fluid">
                                        </div>
                                        <p>مكتب</p>
                                    </div>
                                    <div class="col-sm-12 col-md-6 account_type" onclick="redirectToCreateBroker()">
                                        <div class="img-smm-y">
                                            <img src="{{ asset('HOME_PAGE/images/new/real-estate-agent.png') }} "
                                                class="img-fluid">
                                        </div>
                                        <p>مسوق عقاري</p>
                                    </div>
                            </div>

                        </div>
                    </div>
                    <!-- Add New Broker Card -->

                </div>
            </div>


        </div>

    </div>
</div>
</div>

<script>
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }
    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }
</script>

@endsection
