(function ($) {
	$(document).ready(function () {

		// jQuery form :: submit settings with ajax
		$('#divinizer_form').submit(function () {
			$('#divinizer_save').html("<div id='divinizer_save_message'>saving...</div>");
			$(this).ajaxSubmit({
				success: function () {
					$('#divinizer_save_message').text("Saved!");
				},
				timeout: 5000
			});
			setTimeout(function () {
				$('#divinizer_save_message').fadeOut('3000');
			}, 5000);
			return false;
		});

		$('.et-box-content').on('click', '.et_pb_yes_no_button', function (e) {
			e.preventDefault();
			// Fix for nested .et-box-content triggering checkboxes multiple times.
			e.stopPropagation();

			var $click_area = $(this),
				$box_content = $click_area.closest('.et-box-content'),
				$checkbox = $box_content.find('input[type="checkbox"]'),
				$state = $box_content.find('.et_pb_yes_no_button');

			if ($state.parent().next().hasClass('et_pb_clear_static_css')) {
				$state = $state.add($state.parent());

				if ($checkbox.is(':checked')) {
					$box_content.parent().next().hide();
				} else {
					$box_content.parent().next().show();
				}
			}

			$state.toggleClass('et_pb_on_state et_pb_off_state');

			if ($checkbox.is(':checked')) {
				$checkbox.prop('checked', false);
			} else {
				$checkbox.prop('checked', true);
			}

		});

	});

})(jQuery);

