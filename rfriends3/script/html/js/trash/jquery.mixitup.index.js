 $(function() {
     var layout = 'grid';
     $('#Shop').mixItUp({
         animation: {
             animateChangeLayout: true,
             animateResizeTargets: true,
             effects: 'fade rotateX(-40deg) translateZ(-100px)'
         },
         layout: {
             containerClass: layout
         }
     });
     //selectbox
     $('#FilterSelect').change(function() {
         $('#Shop').mixItUp('filter', this.value);
     });
     $('#SortSelect').change(function() {
         $('#Shop').mixItUp('sort', this.value);
     });
     //layout_change
     $('.ChangeLayoutlist').click(function() {
         layout = 'list';
         $('.ChangeLayoutlist').addClass('cb_active');
         $('.ChangeLayoutgrid').removeClass('cb_active');
         $('.mix').addClass('mixit_list');
         $('.mix').removeClass('mixit_grid');
         $('#Shop').mixItUp('changeLayout', {
             containerClass: layout
         });
     });
     $('.ChangeLayoutgrid').click(function() {
         layout = 'grid';
         $('.ChangeLayoutgrid').addClass('cb_active');
         $('.ChangeLayoutlist').removeClass('cb_active');
         $('.mix').addClass('mixit_grid');
         $('.mix').removeClass('mixit_list');
         $('#Shop').mixItUp('changeLayout', {
             containerClass: layout
         });
     });
 });