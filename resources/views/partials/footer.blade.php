	<!-- footer -->
	<!-- end footer -->

	<!-- JS -->
	<script src="{{asset("front/js/jquery-3.5.1.min.js")}}"></script>
	<script src="{{asset("front/js/bootstrap.bundle.min.js")}}"></script>
	<script src="{{asset("front/js/owl.carousel.min.js")}}"></script>
	<script src="{{asset("front/js/slider-radio.js")}}"></script>
	<script src="{{asset("front/js/select2.min.js")}}"></script>
	<script src="{{asset("front/js/smooth-scrollbar.js")}}"></script>
	<script src="{{asset("front/js/jquery.magnific-popup.min.js")}}"></script>
	<script src="{{asset("front/js/plyr.min.js")}}"></script>
	<script src="{{asset("front/js/main.js")}}"></script>
	<script>
    // Bildirimleri 3 saniye sonra otomatik gizle
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const success = document.getElementById('toast-success');
            const error = document.getElementById('toast-error');
            if (success) success.remove();
            if (error) error.remove();
        }, 3000);
    });
</script>