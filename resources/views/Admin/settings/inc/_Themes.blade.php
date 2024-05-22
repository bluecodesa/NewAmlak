<div class="page-title-box">

    <h6>
        @lang('Website Themes')
    </h6>
    <div class="col-12">
        <div class="card">
          <h5 class="card-header">Color Picker</h5>
          <div class="card-body">
            <div class="row">
                <div class="classic col col-sm-3 col-lg-2">
                  <p>Classic</p>
                  <div class="pickr">

                    <input name="color" class="form-control" type="color" value="{{ $settings->color ?? '#30419b' }}"
            id="color">

                </div>
                </div>
                <div class="monolith col col-sm-3 col-lg-2">
                  <p>Monolith</p>
                  <div class="pickr">

<button type="button" class="pcr-button" role="button" aria-label="toggle color picker dialog" style="--pcr-color: rgba(40, 208, 148, 1);"></button>


</div>
                </div>
                <div class="nano col col-sm-3 col-lg-2">
                  <p>Nano</p>
                  <div class="pickr">

<button type="button" class="pcr-button" role="button" aria-label="toggle color picker dialog" style="--pcr-color: rgba(255, 73, 97, 1);"></button>


</div>
                </div>
              </div>
          </div>
        </div>
      </div>

</div>
