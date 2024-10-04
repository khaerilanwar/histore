import './bootstrap';
import 'flowbite';
import '@splidejs/splide/dist/css/themes/splide-skyblue.min.css';
import Splide from '@splidejs/splide';
// import './sweet-alert';

const alertMsgs = document.querySelectorAll('.alert')
alertMsgs.forEach((alertMsg) => {
    setTimeout(() => {
        alertMsg.classList.add('hidden')
    }, 2000)
})

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.splide').forEach(function (element) {
        let options = {
            type: 'loop',
            autoplay: true,
        }

        // Tambahan options category splide index visitor
        if (element.classList.contains('category-splide')) {
            options = {
                ...options,
                pagination: false,
                arrows: false,
                gap: 20,
                perPage: 4,
                permove: 1,
                breakpoints: {
                    640: {
                        perPage: 1,
                        gap: 0,
                    },
                    768: {
                        perPage: 2,
                    },
                    1024: {
                        perPage: 3,
                    },
                }
            }
        }
        new Splide(element, options).mount();
    }
    );
});