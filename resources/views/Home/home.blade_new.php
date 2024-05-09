@extends('Home.layouts.home.app')
@section('content')

<main class="main">
    <!--==================== HOME ====================-->
    <section class="home container section" id="home">

        <div class="home-inner">
            <div class="home_contnet" data-aos="fade-left" data-aos-anchor-placement="top-center">

                <p id="typed2"
                    data-titles="ندعم المنشأت الناشئة , تمتلك منشأة صغيرة وتطمح للنمو؟ منشأتك صغيرة أومتوسطة ؟ ,  تبغي سهولة إدارة منشأتك الكبيرة ؟">
                    <!-- ندعم المنشأت الناشئة
                    <br>
                    تمتلك منشأة صغيرة وتطمح للنمو؟ منشأتك صغيرة أومتوسطة ؟

                    <br>
                    تبغي سهولة إدارة منشأتك الكبيرة ؟ -->
                </p>
                <h1>
                    أملاك خيارك الأول لادارة الاعمال
                    المالية لمنشأتك التجارية
                </h1>

                <p>! يمكنك الان تعيين محاسبك المالي الخاص بضغطة زر</p>

                <div class="input-form signNowForm">
                    <input type="email" class="input" id="Email" name="Email" placeholder="ادخل بريدك الالكتروني">
                    <input class="button-submit" value="سجل معنا الان" type="submit">
                </div>

                <!-- <a href="#orderProductModal" data-bs-toggle="modal" data-bs-target="#orderProductModal" class="orderPriceBtn"><i class="fi-rr-document-signed"></i> طلب تسعيرة</a> -->
            </div>

            <div class="home_image" data-aos="fade-right" data-aos-anchor-placement="top-center">
                <images src="{{ asset('HOME_PAGE/images/home-banner.png')}}" alt="large distribution" draggable="false">
            </div>
        </div>

    </section>

    <!--==================== Numbers  ====================-->

    <section class="some-numbers">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <images src="{{ asset('HOME_PAGE/images/costumer.svg')}}" alt="">
                        </div>
                        <h3>2000</h3>
                        <h4>عملائنا</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <images src="{{ asset('HOME_PAGE/images/expert.svg')}}" alt="">
                        </div>
                        <h3>200</h3>
                        <h4>محاسبين معتمدين</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <images src="{{ asset('HOME_PAGE/images/financial-advisor.svg')}}" alt="">
                        </div>
                        <h3>10</h3>
                        <h4>خبراء ومستشارين ماليين</h4>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="icon">
                            <images src="{{ asset('HOME_PAGE/images/satisfaction.svg')}}" alt="">
                        </div>
                        <h3>550</h3>
                        <h4>سنوات الخبرة</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--==================== Numbers  ====================-->

    <section class="about-hasibly section">
        <div class="container">
            <h2 class="section_title">
                أياً كان مجال عمل منشأتك
            </h2>
            <p class="section_subtitle">
                سيساعدك <span>أملاك</span> في إدارته بكفاءة
            </p>

            <div class="video-show">
                <!-- <div class="plyr__video-embed" id="player" data-poster="/{{ asset('HOME_PAGE/images/video-poster.png')}}">
                    <iframe
                      src="https://www.youtube.com/embed/bTqVqk7FSmY?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                      allowfullscreen
                      allowtransparency
                      allow="autoplay"
                    ></iframe>
                  </div> -->

                <video id="player" playsinline controls data-poster="/{{ asset('HOME_PAGE/images/video-poster.png')}}">
                    <source src="/path/to/video.mp4" type="video/mp4" />
                    <source src="/path/to/video.webm" type="video/webm" />

                    <!-- Captions are optional -->
                    <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en"
                        default />
                </video>
            </div>

            <div class="sign-now">
                <div class="text">
                    <h3>واجهة سهلة الاستخدام بميزات متعددة</h3>
                    <p>
                        علشان نعرف كل متطلباتك، وفرنا الكثير من الخدمات اللي من خلالها
                        <br>
                        راح تلقى جميع بيانات مشروعك المالية اللي تحتاجها
                    </p>
                </div>
                <a href="#" class="signBtn">سجل الان</a>
            </div>

        </div>
    </section>

    <!--==================== Features  ====================-->

    <section class="features section" id="Features">
        <div class="container">
            <h2 class="section_title">
                مميزات <span>أملاك</span>
            </h2>
            <p class="section_subtitle">
                جميع خدمات أملاك تسير وفق خطوات مدروسة بعناية لنوفر
                <br>
                أعلى درجات الاحترافية في خدمة العملاء
            </p>

            <div class="features-items">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="item">
                            <h3>واجهة سهلة الاستخدام بميزات متعددة</h3>
                            <p>
                                لا حاجة لامتلاك معرفة عميقة في طرق المحاسبة
                                <br>
                                أو نظم تخطيط الموارد المؤسسية
                                <br>
                                لإتقان العمل على أملاك
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="image">
                            <images src="{{ asset('HOME_PAGE/images/feature-1.png')}}" alt="">
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <images src="{{ asset('HOME_PAGE/images/feature-2.png')}}" alt="">
                    </div>

                    <div class="col-lg-6">
                        <div class="item">
                            <h3>ادارة جميع فواتير المبيعات والمشتريات بسهولة</h3>
                            <p>
                                يمكنك الان إنشاء فواتير جديدة من داخل منصة أملاك مباشرة
                                <br>
                                كما يمكنك إدراج جميع فواتيرك من ملفات خارجية, يمكنك أيضا الربط
                                <br>
                                مع جهات خارجية لعرض جميع فواتيرك من خلال المنصة
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="item">
                            <h3>إدارة كاملة لصلاحيات الممستخدمين والفروع</h3>
                            <p>
                                يمكنك الان إضافة موظفينك والتحكم في صلاحياتهم بكل سهولة
                                <br>
                                كما يمكنك دعوة محاسبك الخاص لإنجاز بعض المهام
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <images src="{{ asset('HOME_PAGE/images/feature-3.png')}}" alt="">
                    </div>


                </div>

                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <images src="{{ asset('HOME_PAGE/images/feature-4.png')}}" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="item">
                            <h3>اسناد وتتبع المهام للموظفين</h3>
                            <p>
                                يمكنك إسناد المهام الى الموظفين والمحاسبين وتتبع
                                <br>
                                سير المهام والحصول على إحصائيات بكل المهام المطلوبة
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--==================== Features  ====================-->

    <section class="why-us section">
        <div class="container">
            <h2 class="section_title">
                لماذا <span>أملاك</span>
            </h2>
            <p class="section_subtitle">
                يعد أملاك شريكًا مثاليًا لأعمالك حيث نمكن عملائنا من التركيز على إدارة وتنمية
                <br>
                استثماراتهم لأننا نفهم احتياجاتك ونلبي طلباتك بأفضل صورة ممكنة
            </p>

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-item">
                            <div class="content">
                                <div class="icon">
                                    <images src="{{ asset('HOME_PAGE/images/dashboard.svg')}}" alt="">
                                </div>
                                <h3>أسلوب جديد في إدارتك المالية</h3>
                                <p>
                                    يوفر لك أملاك لوحة بيانات احترافية لجميع معاملاتك المالية، يشمل ذلك
                                </p>
                                <ul>
                                    <li>فواتير متجرك الالكتروني وأنظمة المبيعات المختلفة
                                    </li>
                                    <li>
                                        اشتراكاتك التقنية

                                    </li>
                                    <li>
                                        الربط مع حسابك البنكي
                                    </li>
                                </ul>
                            </div>
                            <div class="image-slide">
                                <images src="{{ asset('HOME_PAGE/images/image-slide.png')}}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-item">
                            <div class="content">
                                <div class="icon">
                                    <images src="{{ asset('HOME_PAGE/images/dashboard.svg')}}" alt="">
                                </div>
                                <h3>أسلوب جديد في إدارتك المالية</h3>
                                <p>
                                    يوفر لك أملاك لوحة بيانات احترافية لجميع معاملاتك المالية، يشمل ذلك
                                </p>
                                <ul>
                                    <li>فواتير متجرك الالكتروني وأنظمة المبيعات المختلفة
                                    </li>
                                    <li>
                                        اشتراكاتك التقنية

                                    </li>
                                    <li>
                                        الربط مع حسابك البنكي
                                    </li>
                                </ul>
                            </div>
                            <div class="image-slide">
                                <images src="{{ asset('HOME_PAGE/images/image-slide.png')}}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-item">
                            <div class="content">
                                <div class="icon">
                                    <images src="{{ asset('HOME_PAGE/images/dashboard.svg')}}" alt="">
                                </div>
                                <h3>أسلوب جديد في إدارتك المالية</h3>
                                <p>
                                    يوفر لك أملاك لوحة بيانات احترافية لجميع معاملاتك المالية، يشمل ذلك
                                </p>
                                <ul>
                                    <li>فواتير متجرك الالكتروني وأنظمة المبيعات المختلفة
                                    </li>
                                    <li>
                                        اشتراكاتك التقنية

                                    </li>
                                    <li>
                                        الربط مع حسابك البنكي
                                    </li>
                                </ul>
                            </div>
                            <div class="image-slide">
                                <images src="{{ asset('HOME_PAGE/images/image-slide.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>

    <!--==================== Features  ====================-->

    <section class="services section" id="Services">
        <div class="container">
            <h2 class="section_title">
                خدمات <span>أملاك</span>
            </h2>
            <p class="section_subtitle">
                تمكن أملاك المنشآت والشركات والافراد من مواكبة التطور المطرد نحو رقمنة الاقتصاد في المملكة العربية
                السعودية
                <br>
                وذلك من خلال نظام متطور تقديم جميع الاعمال المحاسبية عن بعد وبجودة وموثوقية عالية
            </p>

            <div class="services-items">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-1.svg')}}" alt="">
                            </div>
                            <h3>
                                تعيين المحاسب
                                والمستشار المالي
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-2.svg')}}" alt="">
                            </div>
                            <h3>
                                لوحة بيانات لجميع
                                بياناتك المالية
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-3.svg')}}" alt="">
                            </div>
                            <h3>
                                إدارة المهام والخدمات
                                المالية
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-4.svg')}}" alt="">
                            </div>
                            <h3>
                                اسناد وتتبع المهام
                                للموظفين
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-5.svg')}}" alt="">
                            </div>
                            <h3>
                                احصل على المحفظة
                                الالكترونية الخاصة بمنشأتك
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-6.svg')}}" alt="">
                            </div>
                            <h3>
                                حوكمة الادارة المالية
                                وشفافية عالية
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-7.svg')}}" alt="">
                            </div>
                            <h3>
                                آلية مبتكرة لإعتماد
                                النتائج المالية
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="item all">
                            <div class="icon">
                                <img src="{{ asset('HOME_PAGE/images/service-8.svg')}}" alt="">
                            </div>
                            <h3>
                                تصفح جميع الخدمات
                                المالية لكل منشأة
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!--==================== Questions  ====================-->
    <section class="packages section" id="Packages">
        <div class="container">
            <h2 class="section_title">
                باقات وأسعار <span>أملاك</span>
            </h2>
            <p class="section_subtitle">
                توفر لك منصة أملاك باقات مميزة التي تساعدك لادارة خدمات منشائتك
            </p>

            <div class="pro-packages " id="packages">

                <div class="packages-prices-list website ">
                    <div class="pkg-details-item packages-list-header" style="width: 100%;">
                        <div class="package-item-header features pkg-details-info-item">
                            <div class="start-slogan">
                                ابدأ معنا الان
                                <br>
                                واختر خطتك
                                <p>
                                    الدفع سنوياً
                                    <span>(خصم يصل إلى 30%)</span>
                                </p>
                            </div>
                            <div class="pkg-period-wrap">

                                <div class="pkg-period-item">
                                    <input id="monthly-period" checked="" type="radio" name="period" value="monthly">
                                    <label for="monthly-period">شهري</label>
                                </div>
                                <div class="pkg-period-item">
                                    <input id="yearly-period" type="radio" name="period" value="yearly">
                                    <label for="yearly-period">سنوي</label>
                                </div>
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-header package1-header 0">
                            <div class="pkg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="67" height="67" viewBox="0 0 67 67">
                                    <g id="Group_103102" data-name="Group 103102" transform="translate(12249 -1132)">
                                        <circle id="Ellipse_149" data-name="Ellipse 149" cx="33.5" cy="33.5" r="33.5" transform="translate(-12249 1132)" fill="#89e798"></circle>
                                        <path id="Path_26390" data-name="Path 26390" d="M-12322.067,1151.921l-.989,11.306h12.819l-13.888,16.974v-12.344h-13.116Z" transform="translate(108.74 -0.561)" fill="none" stroke="#fff" stroke-width="1.5"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="pkg-name">الأساسية</div>
                            <div class="pkg-price">
                                <div class="month-price"><b class="price--change" data-yearly="149"
                                        data-monthly="299">299</b>
                                    ر.س / شهريا
                                </div>
                                <div style="display: none;" class="year-price"><b class="price--change"
                                        data-yearly="1788" data-monthly="1000">1788</b> سنويا بدلا من
                                    <small class="price--change" data-yearly="3588" data-monthly="3588">3588</small>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="pkg-button" data-ur1313m3t="true">
                                ابدأ الان
                            </a>
                        </div>
                        <div class="pkg-details-info-item package-item-header package1-header featured">
                            <div class="pkg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="67" height="67" viewBox="0 0 67 67">
                                    <g id="Group_103168" data-name="Group 103168" transform="translate(-894 -166.68)">
                                        <circle id="Ellipse_149" data-name="Ellipse 149" cx="33.5" cy="33.5" r="33.5" transform="translate(894 166.68)" fill="#fff"></circle>
                                        <path id="Star" d="M22.14,16.439a1.531,1.531,0,0,0-.444,1.349l1.236,6.843a1.5,1.5,0,0,1-.626,1.5,1.531,1.531,0,0,1-1.627.111l-6.16-3.213a1.573,1.573,0,0,0-.7-.182h-.377a1.129,1.129,0,0,0-.376.125L6.911,26.2a1.625,1.625,0,0,1-.987.153,1.546,1.546,0,0,1-1.238-1.768l1.238-6.843a1.556,1.556,0,0,0-.444-1.362L.457,11.516A1.5,1.5,0,0,1,.083,9.944,1.562,1.562,0,0,1,1.32,8.9l6.912-1a1.547,1.547,0,0,0,1.224-.847L12.5.807A1.447,1.447,0,0,1,12.78.431l.125-.1a.934.934,0,0,1,.224-.181L13.281.1l.236-.1H14.1a1.556,1.556,0,0,1,1.224.834l3.086,6.217a1.546,1.546,0,0,0,1.154.847l6.912,1a1.577,1.577,0,0,1,1.266,1.043,1.511,1.511,0,0,1-.4,1.572Z" transform="translate(913.09 186.892)" fill="none" stroke="#2ca46c" stroke-width="1.5"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="pkg-name">المتقدمة</div>
                            <div class="pkg-price">
                                <div class="month-price"><b class="price--change" data-yearly="149"
                                        data-monthly="299">299</b>
                                    ر.س / شهريا
                                </div>
                                <div style="display: none;" class="year-price"><b class="price--change"
                                        data-yearly="1788" data-monthly="1000">1788</b> سنويا بدلا من
                                    <small class="price--change" data-yearly="3588" data-monthly="3588">3588</small>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="pkg-button" data-ur1313m3t="true">
                                ابدأ الآن</a>

                                <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40.975" height="74.361" viewBox="0 0 40.975 74.361">
                                        <g id="Group_102791" data-name="Group 102791" transform="translate(-13130 -4187)">
                                            <path id="Path_25401" data-name="Path 25401" d="M0,0H40.975V74.361L20.332,58.784,0,74.361Z" transform="translate(13130 4187)" fill="#fed04a"></path>
                                            <g id="Star" transform="translate(13137.205 4207.697)">
                                                <path id="Star-2" data-name="Star" d="M21.141,15.7a1.462,1.462,0,0,0-.424,1.288L21.9,23.52a1.434,1.434,0,0,1-.6,1.434,1.462,1.462,0,0,1-1.554.106l-5.882-3.068a1.5,1.5,0,0,0-.664-.174h-.36a1.078,1.078,0,0,0-.359.12L6.6,25.021a1.552,1.552,0,0,1-.943.146,1.476,1.476,0,0,1-1.182-1.688l1.182-6.534a1.486,1.486,0,0,0-.424-1.3L.437,11A1.434,1.434,0,0,1,.08,9.5a1.491,1.491,0,0,1,1.181-1l6.6-.958a1.477,1.477,0,0,0,1.169-.809L11.938.77A1.382,1.382,0,0,1,12.2.412l.12-.093a.891.891,0,0,1,.214-.173l.145-.053L12.907,0h.559a1.486,1.486,0,0,1,1.169.8l2.947,5.936a1.476,1.476,0,0,0,1.1.809l6.6.958a1.505,1.505,0,0,1,1.209,1,1.443,1.443,0,0,1-.385,1.5Z" transform="translate(0 0)" fill="#fff"></path>
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                        </div>
                        <div class="pkg-details-info-item package-item-header package1-header 2">
                            <div class="pkg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="67" height="67" viewBox="0 0 67 67">
                                    <g id="Group_103169" data-name="Group 103169" transform="translate(-538 -8473.68)">
                                        <circle id="Ellipse_149" data-name="Ellipse 149" cx="33.5" cy="33.5" r="33.5" transform="translate(538 8473.68)" fill="#2ca46c"></circle>
                                        <g id="collaborate" transform="translate(548.17 8999.963)">
                                            <path id="Path_26391" data-name="Path 26391" d="M5.4-508.525c.055,3.986.031,3.86.684,3.9l.354.024.031,1.392c.024,1.274.039,1.415.189,1.62l.165.236-.3.59a18.407,18.407,0,0,0-.975,3.105c-.37,1.376-.668,2.563-.668,2.634a3.05,3.05,0,0,0,.157.6c.086.252.157.472.157.487a1.526,1.526,0,0,1-.354.189,1.874,1.874,0,0,0-1.25,1.8c-.008.5.039.605,3.483,8.294,1.918,4.285,3.514,7.815,3.546,7.854s1.368-.519,2.964-1.234,3.058-1.376,3.255-1.454a1.015,1.015,0,0,0,.7-.794c0-.149-.126-.314-.487-.637-1.274-1.124-1.517-1.517-1.509-2.437a2.362,2.362,0,0,1,2.241-2.421,2.448,2.448,0,0,1,2.516,3.247,3.322,3.322,0,0,0-.165.613.96.96,0,0,0,.613.605,66.653,66.653,0,0,0,6.1-2.783c.259-.244.881-.542.991-.48a1.037,1.037,0,0,1,.118.393,4.308,4.308,0,0,0,.377,1.022l.33.653-.212.244-.22.244v2.83h-.3a.929.929,0,0,0-.472.126c-.173.118-.173.142-.173,2.06,0,1.069.024,2.445.055,3.058l.047,1.124h.881l-.024-2.712-.031-2.712h2.744c1.5,0,4.3-.024,6.219-.055l3.475-.047v1.053c0,.582.024,1.824.055,2.767l.047,1.706h.912l-.047-3.011c-.047-3.451-.031-3.381-.668-3.42l-.362-.024-.031-1.407c-.024-1.274-.039-1.423-.189-1.627l-.165-.22.307-.59a37.455,37.455,0,0,0,1.6-5.857c-.024-.134-.126-.5-.236-.841l-.189-.6.5-.244a1.887,1.887,0,0,0,1.085-2.076c-.1-.456-6.478-15.7-6.565-15.7-.039,0-1.384.55-3,1.226s-2.972,1.242-3.019,1.266c-.079.031-.1-.134-.1-.66a3.267,3.267,0,0,0-.9-2.532,3.165,3.165,0,0,0-2.453-1.038,3.088,3.088,0,0,0-2.461,1.069,3.361,3.361,0,0,0-.59,3.782,3.523,3.523,0,0,0,1.1,1.3c.236.142.259.189.165.244-.2.11-6.337,2.657-6.4,2.657a2.493,2.493,0,0,1-.377-.621l-.322-.621.22-.244.22-.244v-2.807l.354-.039c.613-.071.59.031.59-2.461,0-1.219-.024-2.807-.055-3.522L19.641-512H18.76l.024,3.184.031,3.184H15.56c-1.793,0-4.591.024-6.219.055l-2.964.047v-1.1c0-.605-.024-2.06-.055-3.231L6.275-512H5.363Zm22.878.5a2.471,2.471,0,0,1,1.148,1.085c.165.3.181.44.189,1.47.008,1.242.047,1.415.417,1.572.3.118.2.157,3.546-1.25,1.447-.605,2.657-1.077,2.681-1.046.11.126,6.062,14.466,6.1,14.694a.988.988,0,0,1-.778,1.085c-.189.047-.212.024-.322-.33-.071-.2-.377-1.171-.692-2.146-.582-1.824-.708-2.076-1.187-2.327a2.037,2.037,0,0,0-1.266,0,2.183,2.183,0,0,0-1.368,1.832c-.126.613-.126.613.165,2.461.165,1.014.314,1.926.338,2.021.031.134-.031.212-.267.37-.165.11-2.382,1.069-4.937,2.131s-4.662,1.958-4.7,1.981-.086-.047-.126-.149-.519-1.2-1.061-2.437-.991-2.288-.991-2.327.1-.055.228-.031a4.906,4.906,0,0,0,1.973-.354,3.6,3.6,0,0,0,1.777-3.994,3.36,3.36,0,0,0-2.264-2.406,2.564,2.564,0,0,0-1.164-.126,3.225,3.225,0,0,0-2.6,1.368l-.283.409-.967-2.178c-.527-1.2-1.061-2.374-1.179-2.61l-.22-.432,3.145-1.3a29.172,29.172,0,0,0,3.255-1.447c.275-.393.031-.888-.527-1.069A2.825,2.825,0,0,1,25-504.783a2.639,2.639,0,0,1,.024-2.076,2.2,2.2,0,0,1,1-1.077A2.439,2.439,0,0,1,28.281-508.03Zm-10.425,4.591v1.25l-1.9.055c-1.054.024-3.4.039-5.212.024l-3.3-.024-.024-1.234-.024-1.242,2.3-.024c1.266-.008,3.624-.024,5.236-.039l2.925-.016Zm-.322,2.563a3.88,3.88,0,0,1,.558,1.109c0,.047-1.682.841-3.742,1.761-3.082,1.384-3.75,1.714-3.844,1.879a3.947,3.947,0,0,1-1.753,1.392c-.008.008.142,1,.346,2.2.385,2.359.4,2.736.118,3.365-.252.582-.983.888-1.281.535-.063-.071-.566-1.549-1.116-3.278l-1-3.145.676-2.516A11.272,11.272,0,0,1,7.5-500.616l.322-.535,3.7-.024c2.028-.008,4.159-.024,4.725-.039l1.03-.016Zm2.146,1.745c.063.079.653,1.376,1.313,2.893s1.25,2.83,1.313,2.932a.6.6,0,0,0,.747.236c.2-.063.291-.181.44-.527a2.519,2.519,0,0,1,1.258-1.36,1.947,1.947,0,0,1,1.077-.252,2.33,2.33,0,0,1,2.39,2.249,2.038,2.038,0,0,1-.684,1.793c-.574.574-.865.66-2.146.668-.943,0-1.006.008-1.2.189a.584.584,0,0,0-.2.448,22.381,22.381,0,0,0,1.179,2.885c.653,1.447,1.179,2.712,1.179,2.822a.7.7,0,0,1-.094.322c-.086.118-4.717,2.256-4.882,2.256-.031,0-.039-.2-.008-.456a3.483,3.483,0,0,0-1.627-3.216,3.411,3.411,0,0,0-5.118,2.414,3.07,3.07,0,0,0,1.077,2.885l.629.653-.865.385c-.472.22-1.651.747-2.618,1.179l-1.753.786-.142-.33c-.079-.181-1.565-3.514-3.31-7.4-2.862-6.392-3.161-7.1-3.121-7.382a1,1,0,0,1,.252-.527c.22-.228.637-.448.715-.37.024.024.377,1.093.794,2.39.786,2.477.888,2.673,1.415,2.9a2.054,2.054,0,0,0,1.934-.425,3.366,3.366,0,0,0,.676-1.588c.086-.55.071-.7-.346-3.255-.181-1.093-.189-1.266-.094-1.321a5.179,5.179,0,0,0,1.171-1.03c.244-.322.417-.409,4.308-2.154,2.225-1.006,4.088-1.824,4.135-1.824S19.617-499.2,19.68-499.13Zm19.435,4.8c.024.039.5,1.51,1.069,3.263l1.03,3.2-.684,2.532a11.273,11.273,0,0,1-1.014,3.082l-.338.558-4.662.024-4.662.016-.181-.173a3.881,3.881,0,0,1-.888-2.021c0-.2.142-.267,2.618-1.289,1.431-.6,2.94-1.226,3.333-1.392l.731-.307-.2.385a3.906,3.906,0,0,0-.2.417,4.138,4.138,0,0,0,.818.369,4.359,4.359,0,0,0,.377-.645,3.675,3.675,0,0,1,1.6-1.659c.4-.2.44-.244.4-.432a43.509,43.509,0,0,1-.653-4.583,1.887,1.887,0,0,1,.574-1.242C38.4-494.389,39.028-494.46,39.115-494.326Zm.48,14.835v1.179l-5.11.063c-2.807.031-5.157.039-5.2.016-.079-.024-.1-.354-.1-1.258v-1.219l5.212.016,5.2.024Z" transform="translate(0)" fill="#fff"></path>
                                            <path id="Path_26392" data-name="Path 26392" d="M424.047-510.523c-.024.267-.047.8-.047,1.179v.7h.936l.024-1.14c.024-1.266.047-1.219-.574-1.219H424.1Z" transform="translate(-387.354 -0.919)" fill="#fff"></path>
                                            <path id="Path_26393" data-name="Path 26393" d="M376.377-494.7l-.377.189.511,1.022a5.5,5.5,0,0,0,.59,1.022,4.2,4.2,0,0,0,.77-.354,19.3,19.3,0,0,0-1.085-2.076A2.891,2.891,0,0,0,376.377-494.7Z" transform="translate(-343.128 -15.755)" fill="#fff"></path>
                                            <path id="Path_26394" data-name="Path 26394" d="M462.519-494c-.283.55-.519,1.03-.519,1.061a1.19,1.19,0,0,0,.385.259l.393.2.511-1c.283-.55.519-1.03.519-1.061a1.19,1.19,0,0,0-.385-.259l-.393-.2Z" transform="translate(-422.366 -15.663)" fill="#fff"></path>
                                            <path id="Path_26395" data-name="Path 26395" d="M126.377-47.8c-.212.1-.377.228-.377.275a7.97,7.97,0,0,0,.684,1.384l.346.653.393-.2a1.919,1.919,0,0,0,.385-.236c0-.055-1.014-2.083-1.046-2.083C126.755-47.992,126.582-47.906,126.377-47.8Z" transform="translate(-112.783 -427.521)" fill="#fff"></path>
                                            <path id="Path_26396" data-name="Path 26396" d="M40.511-45.978,40-44.964l.338.2a1.81,1.81,0,0,0,.417.2,5.912,5.912,0,0,0,.605-1.022l.535-1.014-.393-.2a3.344,3.344,0,0,0-.44-.2A11.4,11.4,0,0,0,40.511-45.978Z" transform="translate(-33.544 -428.442)" fill="#fff"></path>
                                            <path id="Path_26397" data-name="Path 26397" d="M88.047-29.277c-.024.393-.047.9-.047,1.132v.417l.432.047a1.97,1.97,0,0,0,.464.031c.016-.016.047-.55.071-1.2L89.006-30h-.9Z" transform="translate(-77.77 -444.105)" fill="#fff"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="pkg-name">الشاملة</div>
                            <div class="pkg-price">
                                <div class="month-price"><b class="price--change" data-yearly="299"
                                        data-monthly="599">599</b>
                                    ر.س / شهريا
                                </div>
                                <div style="display: none;" class="year-price"><b class="price--change"
                                        data-yearly="3588" data-monthly="1000">3588</b> سنويا بدلا من
                                    <small class="price--change" data-yearly="7188" data-monthly="7188">7188</small>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="pkg-button" data-ur1313m3t="true">
                                ابدأ الآن</a>
                        </div>
                        <div class="pkg-details-info-item package-item-header package1-header 2">
                            <div class="pkg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="67" height="67" viewBox="0 0 67 67">
                                    <g id="Group_103174" data-name="Group 103174" transform="translate(-186 -452.923)">
                                        <circle id="Ellipse_149" data-name="Ellipse 149" cx="33.5" cy="33.5" r="33.5" transform="translate(186 452.923)" fill="#fed04a"></circle>
                                        <g id="medal_1_" data-name="medal (1)" transform="translate(160.2 963.48)">
                                            <path id="Path_26398" data-name="Path 26398" d="M58.9-496.54c-.114.057-.9.607-1.725,1.215l-1.522,1.11h-2.01c-2.156,0-2.425.04-2.628.429-.049.1-.366,1.012-.7,2.041l-.61,1.863-1.595,1.134a20.639,20.639,0,0,0-1.709,1.3c-.2.275-.13.624.5,2.535l.61,1.855-.61,1.814a18.12,18.12,0,0,0-.61,2.065.881.881,0,0,0,.163.462,12.867,12.867,0,0,0,1.611,1.239c.016.008-1.392,2.778-3.117,6.155-2.189,4.268-3.149,6.22-3.149,6.4a.728.728,0,0,0,.431.721c.228.121.513.1,4.354-.373,2.384-.292,4.142-.47,4.183-.429s.936,1.62,1.994,3.515,2.01,3.531,2.108,3.636a.806.806,0,0,0,1.05.024c.106-.105.887-1.531,1.733-3.175s1.554-3,1.579-3,.667,1.247,1.424,2.762c1.66,3.32,1.725,3.426,2.108,3.555a.59.59,0,0,0,.586-.057c.269-.13.5-.5,2.287-3.669,1.09-1.936,2.018-3.555,2.059-3.6s1.758.13,4.183.429c3.841.47,4.126.494,4.354.373a.9.9,0,0,0,.334-.275c.228-.429.146-.624-2.392-5.58-1.359-2.656-2.767-5.418-3.125-6.139l-.659-1.3.781-.559c.7-.5,1-.834,1-1.093,0-.057-.277-.964-.61-2.017l-.61-1.919.618-1.936c.627-1.984.659-2.179.374-2.486-.073-.089-.838-.664-1.7-1.288l-1.571-1.126-.578-1.8c-.317-.988-.635-1.9-.692-2.017-.228-.437-.407-.47-2.588-.47H62.819L61.2-495.39a14.228,14.228,0,0,0-1.855-1.215A.744.744,0,0,0,58.9-496.54Zm1.888,2.907,1.481,1.077,1.912.04,1.912.04.545,1.66c.293.915.578,1.733.618,1.822a14.491,14.491,0,0,0,1.562,1.215,11.406,11.406,0,0,1,1.473,1.15c0,.057-.236.842-.529,1.749s-.529,1.7-.529,1.766.244.891.545,1.846c.537,1.693.545,1.733.391,1.846-.09.065-.781.583-1.546,1.142l-1.383,1.029-.578,1.782-.578,1.782-1.912.04c-1.684.032-1.929.057-2.132.194-.13.081-.781.551-1.457,1.037s-1.261.907-1.31.923a5.884,5.884,0,0,1-1.107-.7c-.561-.413-1.245-.907-1.53-1.1l-.513-.348H52.354l-.6-1.782a9.329,9.329,0,0,0-.765-1.952c-.1-.1-.8-.607-1.546-1.15a8.879,8.879,0,0,1-1.335-1.069c.2-.5,1.115-3.393,1.115-3.507,0-.081-.252-.907-.57-1.838s-.57-1.7-.57-1.717.659-.494,1.465-1.077a18.464,18.464,0,0,0,1.587-1.239c.057-.1.35-.931.651-1.863l.537-1.676h1.823a16.452,16.452,0,0,0,2.01-.073c.106-.04.814-.526,1.571-1.085a15.381,15.381,0,0,1,1.489-1.02A16.123,16.123,0,0,1,60.793-493.633Zm10.912,22.385c1.465,2.883,2.653,5.248,2.645,5.264s-1.644-.17-3.6-.413c-3.109-.372-3.613-.413-3.833-.324s-.5.535-2.034,3.264c-.976,1.741-1.8,3.167-1.823,3.175s-.684-1.28-1.465-2.843l-1.424-2.843L61.712-469l1.546-3.029h1.88c1.839,0,1.888,0,2.075-.186a8,8,0,0,0,.838-2.122c.553-1.676.749-2.138.944-2.146C69.02-476.48,70.241-474.123,71.705-471.248ZM49.685-476.3c.033.057.342.964.692,2.008a6.684,6.684,0,0,0,.838,2.081c.212.186.252.186,2.287.186h2.075l1.676,1.215c1.953,1.425,1.977,1.425,2.734.883.26-.178.464-.308.464-.275,0,.065-4.972,9.783-5.037,9.864-.033.032-.863-1.361-1.839-3.11-1.538-2.745-1.807-3.183-2.026-3.272s-.716-.049-3.825.332c-1.969.235-3.589.421-3.6.4-.065-.057,5.3-10.415,5.4-10.415A.265.265,0,0,1,49.685-476.3Z" fill="#fff"></path>
                                            <path id="Path_26399" data-name="Path 26399" d="M164.952-428.749a8.137,8.137,0,0,0-5.647,4.109,9.092,9.092,0,0,0-.537,1.3,7.943,7.943,0,0,0,1.392,7.633,8.171,8.171,0,0,0,6.754,2.986,8.175,8.175,0,0,0,7.364-6.046,6.358,6.358,0,0,0,.179-2.059,5.5,5.5,0,0,0-.22-2.14,8.051,8.051,0,0,0-2.059-3.524,8.152,8.152,0,0,0-4.142-2.238A9.134,9.134,0,0,0,164.952-428.749Zm3.263,1.79a6.427,6.427,0,0,1,3.751,9.431,7.465,7.465,0,0,1-2.466,2.376,5.723,5.723,0,0,1-2.775.732,5.414,5.414,0,0,1-1.628-.1,6.442,6.442,0,0,1-4.834-4.476,7.165,7.165,0,0,1-.1-3.222,9.655,9.655,0,0,1,.366-1.147,6.594,6.594,0,0,1,5.184-3.833A7.71,7.71,0,0,1,168.215-426.958Z" transform="translate(-107.056 -62.233)" fill="#fff"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="pkg-name">الاحترافية</div>
                            <div class="pkg-price">
                                <div class="month-price"><b class="price--change" data-yearly="299"
                                        data-monthly="599">599</b>
                                    ر.س / شهريا
                                </div>
                                <div style="display: none;" class="year-price"><b class="price--change"
                                        data-yearly="3588" data-monthly="1000">3588</b> سنويا بدلا من
                                    <small class="price--change" data-yearly="7188" data-monthly="7188">7188</small>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="pkg-button" data-ur1313m3t="true">
                                ابدأ الآن</a>
                        </div>
                    </div>
                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">اعداد دفتر الشراء</div>
                        </div>
                        <div class="pkg-details-info-item pkg-details-danger-item package-item-title">
                            <div class="icon">
                                <i class="fi-rr-check"></i>

                            </div>
                        </div>
                        <div class="pkg-details-info-item pkg-details-danger-item package-item-title">
                            <div class="icon">
                                <i class="fi-rr-check"></i>

                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title">
                            <div class="icon">
                                <i class="fi-rr-check"></i>
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title">
                            <div class="icon">
                                <i class="fi-rr-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">عدد الصفحات</div>
                        </div>
                        <div class="pkg-details-info-item package-item-title">10 صفحات</div>
                        <div class="pkg-details-info-item package-item-title">10 صفحات</div>
                        <div class="pkg-details-info-item package-item-title">10 صفحات</div>
                        <div class="pkg-details-info-item package-item-title">10 صفحات</div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                تسجيل المشتريات
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">تسجيل المقبوضات</div>
                        </div>
                        <div class="pkg-details-info-item package-item-title">لا يدعم</div>
                        <div class="pkg-details-info-item package-item-title">غير محدود</div>
                        <div class="pkg-details-info-item package-item-title">غير محدود</div>
                        <div class="pkg-details-info-item package-item-title">غير محدود</div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                ضريبة القيمة المضافة
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                العقود المحاسبية
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                الفحص والمراجعة الضريبية
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                تقارير الحسابات الدائنة والمدينة
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                حساب الربح والخسارة
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                التسويات المصرفية
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                الميزانية العمومية
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-minus"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                    <div class="pkg-details-item packages-feature-item">
                        <div class="features pkg-details-info-item">
                            <div class="pkg-feature-title">
                                العقود المحاسبية
                            </div>
                        </div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                        <div class="pkg-details-info-item package-item-title"><div class="icon"><i class="fi-rr-check"></i></div></div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!--==================== Questions  ====================-->
    <section class="questions section" id="Questions">
        <div class="container">
            <h2 class="section_title">
                الأسئلة الشائعة
            </h2>
            <p class="section_subtitle">
                لديك سؤال؟ تحقق من هذه الاجوبه لتساعدك
            </p>
            <div class="accordion questions-wrap" id="questionsWrap">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            ماهي منصة أملاك؟
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#questionsWrap">
                        <div class="accordion-body">
                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                            العربى، حيث يمكنك أن تولد مثل هذا النص
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            ماهي الاجراءات اللازمة لإنشاء موقعي؟
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#questionsWrap">
                        <div class="accordion-body">
                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                            العربى، حيث يمكنك أن تولد مثل هذا النص
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            ماهي الباقات المتاحة في أملاك؟
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#questionsWrap">
                        <div class="accordion-body">
                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                            العربى، حيث يمكنك أن تولد مثل هذا النص
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            ماذا افعل عندما تواجهني مشكلة في موقعي الخاص؟
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#questionsWrap">
                        <div class="accordion-body">
                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                            العربى، حيث يمكنك أن تولد مثل هذا النص
                        </div>
                    </div>
                </div>

            </div>

            <div class="more-faq">
                <a href="#">المزيد من الاسئلة الشائعة</a>
                <p>
                    في حال وجود استفسارات
                    أخرى
                    <a href="#">تواصل معنا</a>
                </p>
            </div>

        </div>
    </section>

    <!--==================== Clients Reviews  ====================-->
    <section class="clients-reviews section">
        <div class="container">
            <h2 class="section_title">
                شهادات عملائنا
            </h2>
            <p class="section_subtitle">
                صورة من اراء عملاء أملاك الذين نتشرف بخدمتهم
            </p>

            <div class="swiper" dir="rtl">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="images">
                                <images src="{{ asset('HOME_PAGE/images/client.png')}}" alt="">
                            </div>
                            <h3>احمد محمد احمد</h3>
                            <h4>مهندس االكترونيات</h4>
                            <p>
                                شركة بلوكود من افضل الشركات التي تعاملت معها, دائما متميزون بالاحترافية. واكثر سعة
                                صدر ليصلوا معك الي اعلي من مبتغاك من مشروعك التي تطلبة واكثر , شركة بمعني الكلمة
                                فيها افضل العاملين في مجال البرمجه والتصميم والشبكات
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="images">
                                <images src="{{ asset('HOME_PAGE/images/client.png')}}" alt="">
                            </div>
                            <h3>احمد محمد احمد</h3>
                            <h4>مهندس االكترونيات</h4>
                            <p>
                                شركة بلوكود من افضل الشركات التي تعاملت معها, دائما متميزون بالاحترافية. واكثر سعة
                                صدر ليصلوا معك الي اعلي من مبتغاك من مشروعك التي تطلبة واكثر , شركة بمعني الكلمة
                                فيها افضل العاملين في مجال البرمجه والتصميم والشبكات
                            </p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="images">
                                <images src="{{ asset('HOME_PAGE/images/client.png')}}" alt="">
                            </div>
                            <h3>احمد محمد احمد</h3>
                            <h4>مهندس االكترونيات</h4>
                            <p>
                                شركة بلوكود من افضل الشركات التي تعاملت معها, دائما متميزون بالاحترافية. واكثر سعة
                                صدر ليصلوا معك الي اعلي من مبتغاك من مشروعك التي تطلبة واكثر , شركة بمعني الكلمة
                                فيها افضل العاملين في مجال البرمجه والتصميم والشبكات
                            </p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="item">
                            <div class="images">
                                <images src="{{ asset('HOME_PAGE/images/client.png')}}" alt="">
                            </div>
                            <h3>احمد محمد احمد</h3>
                            <h4>مهندس االكترونيات</h4>
                            <p>
                                شركة بلوكود من افضل الشركات التي تعاملت معها, دائما متميزون بالاحترافية. واكثر سعة
                                صدر ليصلوا معك الي اعلي من مبتغاك من مشروعك التي تطلبة واكثر , شركة بمعني الكلمة
                                فيها افضل العاملين في مجال البرمجه والتصميم والشبكات
                            </p>
                        </div>
                    </div>



                </div>
                <!-- Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
        </div>
    </section>


    <!--==================== Clients Reviews  ====================-->
    <section class="clients-logos section">
        <div class="container">
            <h2 class="section_title">
                أبرز عملائنا
            </h2>
            <p class="section_subtitle">
                نتشرف بخدمة عدد كبير من المنشات في مجالات متنوعة
            </p>

            <div class="logos-items">
                <images src="{{ asset('HOME_PAGE/images/ministry.png')}}" alt="">
                <images src="{{ asset('HOME_PAGE/images/moyaser.jpg')}}" alt="">
                <images src="{{ asset('HOME_PAGE/images/microsoft.png')}}" alt="">
                <images src="{{ asset('HOME_PAGE/images/moyaser.jpg')}}" alt="">
                <images src="{{ asset('HOME_PAGE/images/spl.png')}}" alt="">
            </div>


            <div class="sign-now">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-12">
                        <h3>دعنا نتحدث لتحقيق هدفك</h3>
                        <p>
                            هل تبحث عن مساعدة في إدارة شؤونك المحاسبية؟ أو ربما أنت مهتم بالاستشارات
                            <br>
                            الضريبية والإدارية، نحن في أملاك نساعدك على المضي قدمًا وندعمك لتطوير أعمالك
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="text-center">
                            <a href="#" class="signBtn">راسلنا عبر الواتساب</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

@include('Home.layouts.inc.__addSubscriberModal')
<script>
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }
    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }
</script>

@endsection
