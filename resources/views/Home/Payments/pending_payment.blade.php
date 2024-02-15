@extends('Admin.layouts.app')
@section('title', __('pending_payment'))
@section('content')
{{--
<div class="modal-content">
    <div class="modal-header border-0">
        <h4 class="modal-title w-100 text-center" id="exampleModalLongTitle">أهلا ومرحبا Hinton and Nolan Traders</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <h5>حسابكم مٌعلق (بانتظار الدفع)!</h5>
        <p>من فضلك قم بإتمام دفع الاشتراك لتتمكن من تفعيل حسابك واستخدام النظام</p>

        <form action="https://tryamlak.com/sub/store2" method="POST" id="payForm">
            @csrf
            <div class="form-row">
                <p>الاشتراك الحالي</p>

                <div class="col-md-12 mb-3 d-flex justify-content-around flex-wrap gap-2" style="align-items: center;">

                    <label>
                        <div class="card text-center border border-primary" style="cursor:pointer">
                            <div class="card-body">
                                <p class="card-text"><br>SAR</p>
                            </div>
                            <div class="card-footer text-muted">
                                &nbsp; <input type="radio" onchange="handleChangexHere()" name="subscription_type" value="" price="" >
                            </div>
                        </div>
                    </label>

                    <input hidden type="text" name="total" id="total" class="form-control">
                    <input hidden name="is_renewed" value="">
                </div>
                <div class="d-flex justify-content-around w-100 mb-3">
                    <a href="https://tryamlak.com/home#pricing" class="btn modal-btn1" target="_blank">قارن بين الخطط</a>
                </div>
            </div>
        </form>
        <div class="row justify-content-around">
            <a data-toggle="modal" data-target="#exampleModal" class="btn modal-btn2 w-auto check_start">
                <span class="item-text pay-btn-change">دفع  SAR</span>
            </a>
            <a href="" class="btn modal-btn2 w-auto">
                <span class="item-text">الدعم الفني</span>
            </a>
        </div>
    </div>
  </div> --}}



  <div class="accountbg"></div>
  <div class="home-btn d-none d-sm-block">
      <a href="{{ route('welcome') }}" class="text-white"><i class="fas fa-home h2"></i></a>
  </div>
  <div class="wrapper-page" style="width: 50%;">
      <div class="card card-pages shadow-none">
          <div class="card-body px-5"> 

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body">
        <h5>حسابكم مٌعلق (بانتظار الدفع)!</h5>
                    <p>من فضلك قم بإتمام دفع الاشتراك لتتمكن من تفعيل حسابك واستخدام النظام</p>



            <form data-action="https://tryamlak.com/sub/store2" method="POST" id="payForm" siq_id="autopick_7341">
                <input type="hidden" name="_token" value="cZcJFrbelq1LhsOvuAI1JO564j4sqLT1HtOjW2Ug">                    <div class="form-row">
                    <p> الاشتراك الحالي</p>

                    <div class="col-md-12 mb-3 d-flex justify-content-around flex-wrap gap-2" style="align-items: center;">
                                                            <label>
                            <div class="card text-center  " style="cursor:pointer">
                                <div class="card-body">

                                    <p class="card-text">
                                      1 اسبوع
                                      <br> 0 SAR
                                    </p>
                                  </div>
                                  <div class="card-footer text-muted">
                                      &nbsp; <input type="radio" onchange="handleChangexHere()" period="1  اسبوع" id="subscription_type" name="subscription_type" value="6" price="0">
                                  </div>
                              </div>
                            </label>
                                                            <label>
                            <div class="card text-center  border border-primary " style="cursor:pointer">
                                <div class="card-body">

                                    <p class="card-text">
                                      1 شهر
                                      <br> 48 SAR
                                    </p>
                                  </div>
                                  <div class="card-footer text-muted">
                                      &nbsp; <input type="radio" onchange="handleChangexHere()" period="1  شهر" id="subscription_type" name="subscription_type" value="7" price="48" checked="">
                                  </div>
                              </div>
                            </label>
                                                            <label>
                            <div class="card text-center  " style="cursor:pointer">
                                <div class="card-body">

                                    <p class="card-text">
                                      1 سنة
                                      <br> 995 SAR
                                    </p>
                                  </div>
                                  <div class="card-footer text-muted">
                                      &nbsp; <input type="radio" onchange="handleChangexHere()" period="1  سنة" id="subscription_type" name="subscription_type" value="17" price="995">
                                  </div>
                              </div>
                            </label>
                                                        <input hidden="" type="text" name="total" id="total" class="form-control">
                        <input hidden="" name="is_renewed" value="">
                    </div>
                     <div class="d-flex justify-content-around w-100 mb-3">
                        <a href="https://tryamlak.com/home#pricing" class="btn modal-btn1" target="_blank">قارن بين الخطط</a>

                    </div>
                </div>

            </form>
                    <div class="row justify-content-around">
        <a data-toggle="modal" data-target="#exampleModal" class="btn modal-btn2 w-auto check_start">

            <span class="item-text pay-btn-change">
                            دفع 48 SAR
                            </span>

        </a>
        <a href="https://tryamlak.com/Support" class="btn modal-btn2 w-auto">
            <span class="item-text">الدعم الفني</span>
        </a>
    </div>
    </div>

  </div>



  </div>
