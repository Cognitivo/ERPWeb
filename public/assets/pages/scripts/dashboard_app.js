
$(document).ready(function() {
  $(".draggable").sortable({
    handle:".widget-thumb-heading",
    connectWith:".draggable",
    opacity: 0.8,
    coneHelperSize: true,
    placeholder: 'portlet-sortable-placeholder',
    forcePlaceholderSize: true,
    tolerance: "pointer",
    helper: "clone",
    revert: 250 // animation in milliseconds
  });
});
