(function(jQuery){jQuery.fn.kenBurning=function(options){var defaults={time:6000},settings=jQuery.extend(defaults,options),$container=jQuery(this),animation="in";jQuery(function(){$container.addClass("kenburning-container");jQuery.fn.kenBurning.doIt();kenBurningplay=setInterval("jQuery.fn.kenBurning.doIt()",settings.time);});jQuery.fn.kenBurning.doIt=function(){var $active=$container.find(".img.active");if($active.length===0){$active=$container.find(".img:last");}var $next=$active.next().length?$active.next():$container.find(".img:first");$active.addClass("last-active").removeClass("active zoomout zoomin");if(animation==="in"){$next.css({left:"0",right:"auto"}).addClass("zoomin").css("transform","scale(1.2)").addClass("active");setTimeout(function(){$active.removeClass("last-active");},6000);animation="out";}else{$next.css({left:"auto",right:"0"}).addClass("zoomout").css("transform","scale(1)").addClass("active");setTimeout(function(){$active.removeClass("last-active");},6000);animation="in";}};};jQuery(".kenburns-play").each(function(){jQuery(this).on("click",function(){if(jQuery(this).hasClass("pause")){clearInterval(kenBurningplay);}else{jQuery.fn.kenBurning.doIt();kenBurningplay=setInterval("jQuery.fn.kenBurning.doIt()",5000);}jQuery(this).toggleClass("pause");});});})(jQuery);