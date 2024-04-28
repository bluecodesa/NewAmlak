<footer class="footer" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6  col-12 mb-0 mb-md-4 pb-0 pb-md-2 first">
                <a href="#" class="logo-footer">
                    <img src="{{ asset('HOME_PAGE/images/amlak1.svg') }}" height="40" alt="">
                </a>
                <p>خيارك الأول لإدارة العقارات عبر منصة متكاملة تخدم مدراء العقارات، والملاك والمستأجرين</p>
                <div class="sub">
                    <h5>سجل معنا ليصلك كل جديد</h5>
                    <form>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="foot-subscribe foot-white mb-3">

                                    <div class="form-icon position-relative">
                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                        <input type="email" name="email" id="emailsubscribe"
                                            class="form-control bg-light border ps-5 rounded ArFont"
                                            placeholder="ادخل بريدك الالكتروني" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="d-grid">
                                    @guest
                        <a href="" class="btn btn-new ArFont" data-toggle="modal" data-target="#addSubscriberModal"
                        style="margin-right: 9px;" onclick="tabsFunc()">سجل معنا الآن</a>
                        @endguest
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
                                <img src="{{ asset('HOME_PAGE/images/new/Location.png') }}" class="img-fluid" />
                            </div>

                            المملكة العربية السعودية
                            <br />
                            (الرياض - جدة - الدمام)
                        </a></li>
                    <li><a href="mailto:hi@bluecode.sa">
                            <div class="img-smm-div">
                                <img src="{{ asset('HOME_PAGE/images/new/Iconly-Bold-Message.png') }}"
                                    class="img-fluid" />
                            </div>
                            {{ $sitting->email }}</a></li>
                    <li><a href="tel:+966500334691">
                            <div class="img-smm-div">
                                <img src="{{ asset('HOME_PAGE/images/new/Iconly-Bold-Call.png') }}"
                                    class="img-fluid" />
                            </div>
                            <p style="direction: ltr;display: inline-block;">+966 {{ $sitting->phone }}</p>
                        </a></li>

                    <li><a href="{{ $sitting->twitter }}" target="_blank">
                            <div class="img-smm-div">
                                <img src="{{ asset('HOME_PAGE/images/new/icons8-twitter-48.png') }}"
                                    class="img-fluid" />
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
<!--end footer-->
<footer class="footer footer-bar">
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="text-sm-start">
                    <p class="mb-0">

                        جميع الحقوق محفوظه  ©
                        <a href="{{ env('COMPANY_URL','https://bluecode.sa') }}" target="_blank" class="text-reset"> لشركة بلوكود</a> -
                        أملاك {{ env('APP_VERSION','V1.0') }}                    </p>
                </div>
            </div>
            <!--end col-->

            <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0 sec" style="text-align: left">
                <span>نقبل طرق الدفع التالية</span>
                <ul class="list-unstyled text-sm-end mb-0 w-auto d-inline-block">


                    <li class="list-inline-item"><a href="javascript:void(0)"><img
                                style="padding: 1px;border: 1px solid #efeeee;"
                                src="{{ asset('HOME_PAGE/images/payments/1280px-Mada_Logo.svg.png') }}"
                                class="avatar avatar-ex-sm" title="American Express" alt=""></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)"><img
                                style="background-color: #efeeee;    border: 1px solid #efeeee;"
                                src="{{ asset('HOME_PAGE/images/payments/pay.png') }}" class="avatar avatar-ex-sm"
                                title="Paypal" alt=""></a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)"><img
                                src="{{ asset('HOME_PAGE/images/payments/master-card.png') }}"
                                class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>


                    <li class="list-inline-item"><a href="javascript:void(0)"><img
                                src="{{ asset('HOME_PAGE/images/payments/visa.png') }}"
                                class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                </ul>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</footer>
<!-- Back to top -->
<a href="#" onclick="topFunction()" id="back-to-top" class="btn btn-icon btn-primary back-to-top"><i
    data-feather="arrow-up" class="icons"></i></a>
<!-- Back to top -->
