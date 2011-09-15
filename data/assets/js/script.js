$(function() {
	$("p.profile .toggle").bind("click", function(e) {
		$("#codeigniter_profiler").toggle();
		e.preventDefault();
	});
});