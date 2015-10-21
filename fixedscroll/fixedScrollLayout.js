/**
 * Copyright 2013, Emma L. Baumstarck
 * Adapted from http://www.codrops.com
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
(function($){
	$.fn.fixedScroll=function(userConfig){
		var config={
			currentLink:0,
			$body:$('html,body'),
			numSections:null, // the number of sections to progammatically ensure exist
			backgrounds:null, // optional backgrounds to apply to the sections
			sectionContent:'Content here', // default body for each section
		};
		$.extend(config,userConfig); // merge user config into defaut config
		var numSections=Math.max(config.numSections||0,config.backgrounds.length);
		if(!numSections)return;
		var sectionStr=[];
		for(var j=0;j<numSections;++j){sectionStr.push(''+'<section id="section'+j.toString()+'">'+'<div class="sectionwrap">'+config.sectionContent+'</div>'+'</section>');}
		sectionStr=sectionStr.join('');
		$('#scroller').html(sectionStr);
		var $sections=$('#scroller > section');
		// set the background for each section
		if (config.backgrounds.length){
			$sections.each(function(k,sec){
				if(k<config.backgrounds.length){
					var background=config.backgrounds[k];
					if(background.match(/\.\w{3,4}$/))$(sec).css("background-image", "url(" + background + ")"); // it's a url for an image
					else $(sec).css("background-color",background);
				}
			});
		}
	};
})(jQuery);
