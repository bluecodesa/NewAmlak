

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <div class="row  w-100 text-center">
                    <div class="col-12">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-weight:700">سجل معنا في
                            أملاك</h5>

                    </div>
                    <div class="col-12">
                        <p style="font-size: 12px">سجل البيانات أدناه في أملاك</p>

                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="">
                        <ul style="list-style: none; padding-right: 0;  padding-bottom: 0;      margin-bottom: 5px;">
                            @foreach ($errors->all() as $error)
                                @if ($error != 'auth.failed')
                                    <li class="alert alert-danger">{{ $error }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif



                <section class="signup-step-container">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">
                                <div class="wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul class="nav nav-tabs" role="tablist" hidden>
                                            <li role="presentation" class="active">
                                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                                    aria-expanded="true"><span class="round-tab">1 </span> <i>Step
                                                        1</i></a>
                                            </li>
                                            <li role="presentation" class="disabled">
                                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                                    aria-expanded="false"><span class="round-tab">2</span> <i>Step
                                                        2</i></a>
                                            </li>

                                        </ul>
                                    </div>


                                    <div class="tab-content" id="main_form">
                                        <div class="tab-pane active" role="tabpanel" id="step1">
                                            <p style="text-align: center;font-weight: 900; margin-bottom: 25px;">من فضلك
                                                اختر نوع الحساب المراد التسجيل فيه</p>
                                            <div class="row account_row">
                                                <div class="col-sm-12 col-md-6 account_type next-step">
                                                    <div class="img-smm">
                                                        <img src="{{ asset('HOME_PAGE/images/new/building-_5_.png') }}"
                                                            class="img-fluid">
                                                    </div>
                                                    <p>مكتب</p>
                                                </div>
                                                <div class="col-sm-12 col-md-6 account_type">
                                                    <div class="img-smm-y">
                                                        <img src="{{ asset('HOME_PAGE/images/new/real-estate-agent.png') }} "
                                                            class="img-fluid">
                                                    </div>
                                                    <p>مسوق عقاري</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step2">

                                            <form id="register" enctype="multipart/form-data" method="POST"
                                                action="{{ route('offices.create') }}">
                                                @csrf


                                                <div class="row">
                                                    <div class="col-6 mb-4 ">
                                                        <label for="CR_number">رقم السجل التجاري</label>
                                                        <span class="not_required">(اختياري)</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="ادخل رقم السجل التجاري" id="CR_number"
                                                            name="CRN" value="{{ old('CRN') ?? '' }}" />
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <label for="Company_name">اسم الشركة <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="ادخل اسم الشركة" id="company_name"
                                                            name="Company_name"
                                                            value="{{ old('Company_name') ?? '' }}" />
                                                    </div>

                                                    <div class="col-6 mb-4">
                                                        <label for="contract">شعار الشركة</label>
                                                        <span class="not_required">(اختياري)</span>

                                                        <input type="file" class="form-control" id="company_logo"
                                                            name="company_logo"
                                                            accept="image/png, image/jpg, image/jpeg" />
                                                        <input type="hidden" name="fromWhere" id="fromWhere"
                                                            value="home_page" />
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <label for="presenter_email">البريد الالكتروني للشركة <span
                                                                class="text-danger">*</span></label>

                                                        <input type="email" class="form-control"
                                                            id="presenter_email"
                                                            value="{{ old('presenter_email') ?? '' }}"
                                                            name="presenter_email" required
                                                            placeholder="ادخل البريد الالكتروني" />
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <label for="presenter_name">اسم ممثل الشركة <span
                                                                class="text-danger">*</span></label>

                                                        <input type="text" class="form-control"
                                                            id="presenter_name" name="presenter_name"
                                                            value="{{ old('presenter_name') ?? '' }}" required
                                                            placeholder="ادخل اسم الممثل" />
                                                    </div>

                                                    <div class="col-6 mb-4">
                                                        <label for="presenter_number">رقم ممثل الشركة (واتس اب)<span
                                                                class="text-danger">*</span></label>
                                                        <div style="position:relative">

                                                            <input type="tel" class="form-control"
                                                                id="presenter_number" minlength="9" maxlength="9"
                                                                pattern="[0-9]*"
                                                                oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                                onchange="try{setCustomValidity('')}catch(e){}"
                                                                placeholder="599123456" name="presenter_number"
                                                                required value="{{ old('presenter_number') ?? '' }}" />

                                                            <span
                                                                style="    position: absolute;left: -1px;top: 0;background-color: #e9ecef;height: 100%;display: flex; align-items: center;  justify-content: center;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding: 0px 20px;border: 1px solid #ced4da; border-top-left-radius: 14px;border-bottom-left-radius: 14px;">966+</span>
                                                        </div>
                                                    </div>



                                                    <div class="col-6 mb-4">
                                                        <label for="city">المدينة <span
                                                                class="text-danger">*</span></label>
                                                        <!-- <input type="text" class="form-control" placeholder="ادخل اسم المدينة" id="city" name="city" />-->
                                                        <select class="form-control" id="city" required
                                                            name="city">
                                                            <option value="">إختر</option>
                                                            <option value="مدينة الرياض"
                                                                @if (old('city') == 'مدينة الرياض') {{ 'selected' }} @endif>
                                                                مدينة
                                                                الرياض
                                                            </option>
                                                            <option value="جدة"
                                                                @if (old('city') == 'جدة') {{ 'selected' }} @endif>
                                                                جدة
                                                            </option>
                                                            <option value="مكة المكرمة"
                                                                @if (old('city') == 'مكة المكرمة') {{ 'selected' }} @endif>
                                                                مكة المكرمة
                                                            </option>
                                                            <option value="المدينة المنورة"
                                                                @if (old('city') == 'المدينة المنورة') {{ 'selected' }} @endif>
                                                                المدينة
                                                                المنورة
                                                            </option>
                                                            <option value="سلطانه"
                                                                @if (old('city') == 'سلطانه') {{ 'selected' }} @endif>
                                                                سلطانه</option>
                                                            <option value="الدمام"
                                                                @if (old('city') == 'الدمام') {{ 'selected' }} @endif>
                                                                الدمام</option>
                                                            <option value="الطائف"
                                                                @if (old('city') == 'الطائف') {{ 'selected' }} @endif>
                                                                الطائف</option>
                                                            <option value="تبوك"
                                                                @if (old('city') == 'تبوك') {{ 'selected' }} @endif>
                                                                تبوك</option>
                                                            <option value="الخرج"
                                                                @if (old('city') == 'الخرج') {{ 'selected' }} @endif>
                                                                الخرج</option>
                                                            <option value="بريدة"
                                                                @if (old('city') == 'بريدة') {{ 'selected' }} @endif>
                                                                بريدة</option>
                                                            <option value="خميس مشيط"
                                                                @if (old('city') == 'خميس مشيط') {{ 'selected' }} @endif>
                                                                خميس مشيط
                                                            </option>
                                                            <option value="الهفوف"
                                                                @if (old('city') == 'الهفوف') {{ 'selected' }} @endif>
                                                                الهفوف</option>
                                                            <option value="المبرز"
                                                                @if (old('city') == 'المبرز') {{ 'selected' }} @endif>
                                                                المبرز</option>
                                                            <option value="حفر الباطن"
                                                                @if (old('city') == 'حفر الباطن') {{ 'selected' }} @endif>
                                                                حفر
                                                                الباطن
                                                            </option>
                                                            <option value="حائل"
                                                                @if (old('city') == 'حائل') {{ 'selected' }} @endif>
                                                                حائل</option>
                                                            <option value="نجران"
                                                                @if (old('city') == 'نجران') {{ 'selected' }} @endif>
                                                                نجران</option>
                                                            <option value="الجبيل"
                                                                @if (old('city') == 'الجبيل') {{ 'selected' }} @endif>
                                                                الجبيل</option>
                                                            <option value="أبها"
                                                                @if (old('city') == 'أبها') {{ 'selected' }} @endif>
                                                                أبها</option>
                                                            <option value="ينبع"
                                                                @if (old('city') == 'ينبع') {{ 'selected' }} @endif>
                                                                ينبع</option>
                                                            <option value="مدينه الخبر"
                                                                @if (old('city') == 'مدينه الخبر') {{ 'selected' }} @endif>
                                                                مدينه
                                                                الخبر
                                                            </option>
                                                            <option value="عرعر"
                                                                @if (old('city') == 'عرعر') {{ 'selected' }} @endif>
                                                                عرعر</option>
                                                            <option value="سكاكا"
                                                                @if (old('city') == 'سكاكا') {{ 'selected' }} @endif>
                                                                سكاكا</option>
                                                            <option value="جازان"
                                                                @if (old('city') == 'جازان') {{ 'selected' }} @endif>
                                                                جازان</option>
                                                            <option value="القريات"
                                                                @if (old('city') == 'القريات') {{ 'selected' }} @endif>
                                                                القريات</option>
                                                            <option value="الظهران"
                                                                @if (old('city') == 'الظهران') {{ 'selected' }} @endif>
                                                                الظهران</option>
                                                            <option value="القطيف"
                                                                @if (old('city') == 'القطيف') {{ 'selected' }} @endif>
                                                                القطيف</option>
                                                            <option value="الباحة"
                                                                @if (old('city') == 'الباحة') {{ 'selected' }} @endif>
                                                                الباحة</option>
                                                            <option value="تاروت"
                                                                @if (old('city') == 'تاروت') {{ 'selected' }} @endif>
                                                                تاروت</option>
                                                            <option value="بيشة"
                                                                @if (old('city') == 'بيشة') {{ 'selected' }} @endif>
                                                                بيشة</option>
                                                            <option value="الرس"
                                                                @if (old('city') == 'الرس') {{ 'selected' }} @endif>
                                                                الرس</option>
                                                            <option value="الشفا"
                                                                @if (old('city') == 'الشفا') {{ 'selected' }} @endif>
                                                                الشفا</option>
                                                            <option value="المذنب"
                                                                @if (old('city') == 'المذنب') {{ 'selected' }} @endif>
                                                                المذنب</option>
                                                            <option value="الخفجي"
                                                                @if (old('city') == 'الخفجي') {{ 'selected' }} @endif>
                                                                الخفجي</option>
                                                            <option value="الدوادمي"
                                                                @if (old('city') == 'الدوادمي') {{ 'selected' }} @endif>
                                                                الدوادمي
                                                            </option>
                                                            <option value="صبيا"
                                                                @if (old('city') == 'صبيا') {{ 'selected' }} @endif>
                                                                صبيا</option>
                                                            <option value="الزلفي"
                                                                @if (old('city') == 'الزلفي') {{ 'selected' }} @endif>
                                                                الزلفي</option>
                                                            <option value="ابو عريش"
                                                                @if (old('city') == 'ابو عريش') {{ 'selected' }} @endif>
                                                                ابو عريش
                                                            </option>
                                                            <option value="الصفوة"
                                                                @if (old('city') == 'الصفوة') {{ 'selected' }} @endif>
                                                                الصفوة</option>
                                                            <option value="عفيف"
                                                                @if (old('city') == 'عفيف') {{ 'selected' }} @endif>
                                                                عفيف</option>
                                                            <option value="رابغ"
                                                                @if (old('city') == 'رابغ') {{ 'selected' }} @endif>
                                                                رابغ</option>
                                                            <option value="طريف"
                                                                @if (old('city') == 'طريف') {{ 'selected' }} @endif>
                                                                طريف</option>
                                                            <option value="الدلم"
                                                                @if (old('city') == 'الدلم') {{ 'selected' }} @endif>
                                                                الدلم</option>
                                                            <option value="املج"
                                                                @if (old('city') == 'املج') {{ 'selected' }} @endif>
                                                                املج</option>
                                                            <option value="العلا"
                                                                @if (old('city') == 'العلا') {{ 'selected' }} @endif>
                                                                العلا</option>
                                                            <option value="ابقيق"
                                                                @if (old('city') == 'ابقيق') {{ 'selected' }} @endif>
                                                                ابقيق</option>
                                                            <option value="بدر حنين"
                                                                @if (old('city') == 'بدر حنين') {{ 'selected' }} @endif>
                                                                بدر حنين
                                                            </option>
                                                            <option value="الوجه"
                                                                @if (old('city') == 'الوجه') {{ 'selected' }} @endif>
                                                                الوجه</option>
                                                            <option value="البكيرية"
                                                                @if (old('city') == 'البكيرية') {{ 'selected' }} @endif>
                                                                البكيرية
                                                            </option>
                                                            <option value="النماص"
                                                                @if (old('city') == 'النماص') {{ 'selected' }} @endif>
                                                                النماص</option>
                                                            <option value="السليل"
                                                                @if (old('city') == 'السليل') {{ 'selected' }} @endif>
                                                                السليل</option>
                                                            <option value="تربه"
                                                                @if (old('city') == 'تربه') {{ 'selected' }} @endif>
                                                                تربه</option>
                                                            <option value="الجموم"
                                                                @if (old('city') == 'الجموم') {{ 'selected' }} @endif>
                                                                الجموم</option>
                                                            <option value="ضباء"
                                                                @if (old('city') == 'ضباء') {{ 'selected' }} @endif>
                                                                ضباء</option>
                                                            <option value="في الطراف"
                                                                @if (old('city') == 'في الطراف') {{ 'selected' }} @endif>
                                                                في الطراف
                                                            </option>
                                                            <option value="القيصومة"
                                                                @if (old('city') == 'القيصومة') {{ 'selected' }} @endif>
                                                                القيصومة
                                                            </option>
                                                            <option value="البطالية"
                                                                @if (old('city') == 'البطالية') {{ 'selected' }} @endif>
                                                                البطالية
                                                            </option>
                                                            <option value="المنيزلة"
                                                                @if (old('city') == 'المنيزلة') {{ 'selected' }} @endif>
                                                                المنيزلة
                                                            </option>
                                                            <option value="المجاردة"
                                                                @if (old('city') == 'المجاردة') {{ 'selected' }} @endif>
                                                                المجاردة
                                                            </option>
                                                            <option value="تنومة"
                                                                @if (old('city') == 'تنومة') {{ 'selected' }} @endif>
                                                                تنومة</option>
                                                            <option value="القرين"
                                                                @if (old('city') == 'القرين') {{ 'selected' }} @endif>
                                                                القرين</option>
                                                            <option value="الأوجام"
                                                                @if (old('city') == 'الأوجام') {{ 'selected' }} @endif>
                                                                الأوجام
                                                            </option>
                                                            <option value="فرسان"
                                                                @if (old('city') == 'فرسان') {{ 'selected' }} @endif>
                                                                فرسان</option>
                                                            <option value="مينداك"
                                                                @if (old('city') == 'مينداك') {{ 'selected' }} @endif>
                                                                مينداك</option>
                                                            <option value="الأرطاوية"
                                                                @if (old('city') == 'الأرطاوية') {{ 'selected' }} @endif>
                                                                الأرطاوية
                                                            </option>


                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <label for="package">نوع الاشتراك <span
                                                                class="text-danger">*</span></label>
                                                        <select type="package" class="form-control" id="package"
                                                            name="package" required>

                                                                    <option>

                                                                        </option>

                                                        </select>
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <label for="password">كلمة المرور <span
                                                                class="text-danger">*</span></label>

                                                        <input type="password" class="form-control" id="password"
                                                            name="password" required placeholder="ادخل كلمة المرور" />
                                                    </div>
                                                    <div class="col-6 mb-4">
                                                        <label for="password_confirmation">تاكيد كلمة المرور <span
                                                                class="text-danger">*</span></label>
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation"
                                                            required placeholder="ادخل كلمة المرور" />
                                                    </div>



                                                    <div class="col-12 mb-4">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button type="submit"
                                                                class="btn btn-submit">تسجيل</button>
                                                                <button style="    background-color: #fff;
                                                                color: #333030;
                                                                border: 1px solid #333030;"
                                                                class="prev-step btn btn-new-b ArFont">رجوع</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
