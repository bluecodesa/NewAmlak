<head>
    <meta charset="utf-8" />
    <title>خيارك الأول لإدارة الاصول العقارية</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="نظام أملاك لإدارة المستأجرين" />
    <meta name="keywords" content="المستأجرين, متابعة عقود ايجار, تنبيهات, ملاك العقارات, نظام الالكتروني" />
    <meta name="author" content="bluecode" />
    <meta name="email" content="hi@bluecode.sa" />
    <meta name="website" content="https://bluecode.sa" />
    <meta name="Version" content="v3.2.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/logo1.png') }}">
    <!-- Bootstrap -->
    <link href="{{ asset('HOME_PAGE/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('HOME_PAGE/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/css/tiny-slider.css') }}" />
    <!-- Main Css -->



    <?php
    $primary_color = '#497AAC' ;
          $secondary_color = '#497AAC17';
          $gradient_color = '#E0EFF9';
          $side_icon_primary ='#566c82';
          $side_icon_secondary ='#bac1cc';
          $img='HOME_PAGE/icons/group.png';
          $date = 2022;
          $logo = 'HOME_PAGE/images/amlak1.svg';
          $name = 'أملاك';
          $font1= 'tajawal0';
          $font2= 'sans-serif';


      $setting = App\Models\Setting::find(1);
      if($setting->login_as_home ==1){
          $primary_color = '#3f492e' ;
          $secondary_color = '#99a5835e';
          $gradient_color = '#E0EFF9';
          $side_icon_primary ='#566c82';
          $side_icon_secondary ='#bac1cc';
          $img='HOME_PAGE/icons/group1.png';
          $date = 2023;
          $logo = 'HOME_PAGE/images/logo22.png';
          $name = 'مشارف';
          $font1= 'tajawal';
          $font2= 'gee';
      }

  ?>
  <style>
      :root {
          --primary: {{ $primary_color }};
          --secondary: {{ $secondary_color }};
          --gradient: {{ $gradient_color }};
          --side_icon_primary: {{ $side_icon_primary }};
          --side_icon_secondary: {{ $side_icon_secondary }};
          --font1: {{ $font1 }};
          --font2: {{ $font2 }};

      }
  </style>
    <link href="{{ asset('HOME_PAGE/css/style-rtl.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('HOME_PAGE/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/font-awesome/css/font-awesome.min.css') }}">

    <style>
        .fixed-custom {
            position: fixed;
            top: 94px;
            width: 87.1%;
            background-color: #ffff;
            margin-right: -24px;
            z-index: 9999999999;
            display: flex;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.05);
        }


        @media(max-width:768px) {
            .modal-body .col-6.mb-4 {
                width: 100%;
            }
        }

        @media (max-width: 767px) {
            .carousel-inner .carousel-item>div {
                display: none;
            }

            .carousel-inner .carousel-item>div:first-child {
                display: block;
            }
        }

        .clients-container .carousel-inner .carousel-item.active,
        .clients-container .carousel-inner .carousel-item-next,
        .clients-container .carousel-inner .carousel-item-prev {
            display: flex;
        }

        /* medium and up screens */
        @media (min-width: 768px) {

            .clients-container .carousel-inner .carousel-item-end.active,
            .clients-container .carousel-inner .carousel-item-next {
                transform: translateX(25%);
            }

            .clients-container .carousel-inner .carousel-item-start.active,
            .clients-container .carousel-inner .carousel-item-prev {
                transform: translateX(-25%);
            }

            .clients-container .carousel-inner .col-md-2 {
                width: 20%;
            }

            .clients-container .carousel-inner .col-md-2 img {
                width: 73% !important;
            }


        }

        .clients-container .card {
            border: 0px
        }

        .clients-container .carousel-inner .carousel-item-end,
        .clients-container .carousel-inner .carousel-item-start {
            transform: translateX(0);
        }
    </style>
</head>
