<!-- javascript -->
<!-- SLIDER -->
<script src="{{ asset('HOME_PAGE/js/tiny-slider.js') }} "></script>
<!-- Icons -->
<script src="{{ asset('HOME_PAGE/js/feather.min.js') }}"></script>
<!-- Main Js -->
<script src="{{ asset('HOME_PAGE/js/plugins.init.js') }}"></script>

<!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
<script src="{{ asset('HOME_PAGE/js/app.js') }}"></script>

<!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('HOME_PAGE/js/bootstrap.bundle.min.js') }}"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script>
    function attachFile() {
        document.querySelector('form.form-rec input[type="file"]').style.display = "block";
        document.querySelector('.hidee').style.display = "none";
        document.querySelector('.displayyy').style.display = "block";
    }

    function changePeriod(value) {
        document.querySelector('.active-check').classList.remove('active-check');
        event.target.classList.add('active-check');

        if (value == 1) // month
        {
            document.querySelector('.change_period.first .month').innerText = "رس / شهريا";
            document.querySelector('.change_period.first .yel-price').innerText = "49 ";

            // document.querySelector('.change_period.second .month').innerText = "رس / شهريا";
            //    document.querySelector('.change_period.second .yel-price:').innerText = "30";
        } else if (value == 2) {
            document.querySelector('.change_period.first .month').innerText = "رس / سنويا";
            document.querySelector('.change_period.first .yel-price').innerText = "588 ";
            //    document.querySelector('.change_period.second .month').innerText = "رس / سنويا";
            //   document.querySelector('.change_period.second .yel-price').innerText = "20";
        }

    }
    let items = document.querySelectorAll('.clients-container .carousel .carousel-item')

    items.forEach((el) => {
        const minPerSlide = 5
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                // wrap carousel by using first child
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })
</script>
