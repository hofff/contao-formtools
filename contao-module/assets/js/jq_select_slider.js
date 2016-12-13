/*
 * turn selects into sliders
 *
 * requires jquery ui slider (and its dependencies)
 * add jquery ui touch punch for mobile compat
 *
 * add HofffSelectSlider css class to a surrounding container of the select.
 * add data-target attribute containing a selector to the context container.
 * if no target is given the context container is the target.
 * the slider and buttons are appended to the end of the target.
 */
!function($) {

var indexOf = function(value) { return Math.floor(value / 200); },
	valueOf = function(index) { return index * 200 + 100; },
	max = function(n) { return n * 200 - 1; },
	findTarget = function($context) {
		var target = $context.data("target"), $target;

		if(!target) return $context;

		$target = $context.find(target);
		if($target.length) return $target.eq(0);

		$target = $(target);
		if($target.length) return $target.eq(0);

		return $context;
	},
	buildOptions = function($select, $container) {
		$container.empty();
		$select.find("option").each(function(i) {
			var $option = $(this);
			$("<div></div>")
				.data("index", i)
				.attr("data-value", $option.attr("value"))
				.text($option.text())
				.appendTo($container);
		});
		return $container.children();
	},
	ns = ".hofff-select-slider",
	tpl = "\
<div class=\"hofff-select-slider\">\
	<div class=\"hofff-select-slider-bar\">\
		<div class=\"hofff-select-slider-helper\">\
			<div class=\"hofff-select-slider-helper\">\
				<div class=\"hofff-select-slider-helper\">\
					<span class=\"ui-slider-handle\">\
						<span class=\"hofff-select-slider-label\"></span>\
					</span>\
				</div>\
			</div>\
		</div>\
	</div>\
	<div class=\"hofff-select-slider-options\">\
	</div>\
</div>\
",
	$window = $(window),
	SelectSlider;

SelectSlider = function(context) {
	var self = this, $helper;
	self.$context = $(context);
	self.$select = self.$context.find("select").eq(0);
	self.$container = $(tpl);

	findTarget(self.$context).append(self.$container);
	$helper = self.$container.find(".hofff-select-slider-helper");

	self.$slider = $helper.eq(0);
	self.$capture = $helper.eq(1);
	self.$spacer = $helper.eq(2);
	self.$handle = self.$container.find(".ui-slider-handle");
	self.$label = self.$container.find(".hofff-select-slider-label");
	self.$options = buildOptions(self.$select, self.$container.find(".hofff-select-slider-options"));

	self.slider = self.$slider.slider({
		max: max(self.$options.length)
	}).slider("instance");

	self._fromSlider = function(event, ui) { self.set(indexOf(ui.value)); };
	self._fromSelect = function() { self.set(self.$select.prop("selectedIndex")); };
	self._fromOption = function() { self.set($(this).data("index")); };
	self._enableSync = function() { self.sync = true; };
	self._disableSync = function() { self.sync = false; };
	self._clearSlider = function() { self.$slider.width(""); };
	self._spaceSlider = function() { self.$slider.width(self.$spacer.width()); };
	self._resizeSpacer = function() { self.$spacer.width("").width(self.$slider.width() - self.$handle.width()); };
};
SelectSlider.prototype.$option = $();
SelectSlider.prototype.sync = true;
SelectSlider.prototype.syncing = false;
SelectSlider.prototype.set = function(index) {
	var self = this, value;

	if(index < 0 || index >= self.$options.length) return;

	if(self.index != index) {
		self.$option.removeClass("active");
		self.$option = self.$options.eq(index);
		self.$option.addClass("active");
		self.$label.text(self.$option.text());
		self.index = index;
	}

	if(self.sync && !self.syncing) {
		self.syncing = true;
		value = valueOf(index);
		if(value != self.slider.value()) self.slider.value(value);
		if(index != self.$select.prop("selectedIndex")) self.$select.prop("selectedIndex", index).trigger("change");
		self.syncing = false;
	};
};
SelectSlider.prototype.enable = function() {
	var self = this;

	self.$select.on("change" + ns, self._fromSelect);
	self.$capture.on("mousedown" + ns, self._spaceSlider);
	self.$container.on("slidestart" + ns, self._disableSync);
	self.$container.on("slide" + ns, self._fromSlider);
	self.$container.on("slidestop" + ns, self._enableSync);
	self.$container.on("slidestop" + ns, self._clearSlider);
	self.$container.on("slidechange" + ns, self._fromSlider);
	self.$container.on("click" + ns, ":data(index)", self._fromOption);
	$window.on("resize" + ns, self._resizeSpacer);

	self._fromSelect();
	setTimeout(self._resizeSpacer, 10);
};
SelectSlider.prototype.disable = function() {
	var self = this;
	self.$select.off(ns);
	self.$capture.off(ns);
	self.$container.off(ns);
	$window.off("resize" + ns, self._resizeSpacer);
};

if(!window.hofff) window.hofff = {};
window.hofff.SelectSlider = SelectSlider;

$(function() {
	$(".HofffSelectSlider").each(function() {
		new SelectSlider(this).enable();
	});
});

}(jQuery);