jQuery(function($) {
	var update = function($conditionals) {
		$conditionals.find("[data-conditional-control]").each(function() {
			var $subject = $(this),
				$control = $conditionals.find($subject.data("conditional-control")),
				value = $subject.data("conditional-value");
			if(value && !$.isArray(value)) value = [ value ];
			$subject.toggleClass("invisible", value ? value.indexOf($control.val()) < 0 : !$control.length);
		});
	};
	$(document.body).on("change", ".HofffFormtoolsConditional", function(event) {
		update($(this));
	}).find(".HofffFormtoolsConditional").each(function() {
		update($(this));
	}).removeClass("invisible");
});