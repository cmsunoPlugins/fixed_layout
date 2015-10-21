//
// CMSUno
// Plugin Fixed Layout
//
function f_load_fixedLayout(){
	jQuery(document).ready(function(){
		jQuery.getScript("uno/plugins/fixed_layout/tinyColorPicker/jqColorPicker.min.js");
		jQuery.post('uno/plugins/fixed_layout/fixed_layout.php',{'action':'load','unox':Unox},function(r){var o='',data=jQuery.parseJSON(r),c=0;
			jQuery.each(data,function(k,v){
				if(k=='menuOffset')document.getElementById("fixedLayoutMenu").value=v;
				else o+='<tr><td>'+k+'</td><td><select name="'+k+'Sel" onChange="f_color_fixedLayout(this,'+c+');" ><option value="color" '+(v.typ=='color'?'selected':'')+'>color</option><option value="img" '+(v.typ=='img'?'selected':'')+'>img</option></select></td><td><input type="text" id="layoutCol'+c+'" '+(v.typ=='color'?'class="co"':'onclick="f_finder_select(\'layoutCol'+c+'\')"')+' value="'+v.ref+'" /></td></tr>';
				++c;
				});
			jQuery('#layout').append(o);
			jQuery('#layout input.co').colorPicker();
			jQuery(document).click(function(e){if(jQuery('#blocFixedLayout').length==0)jQuery("#layout input").spectrum("destroy");jQuery(".sp-container").remove();});
		});
	});
}
//
function f_save_fixedLayout(){
	var a=document.getElementById("layout").getElementsByTagName("select"),b='',c=document.getElementById("layout").getElementsByTagName("input"),h=[];
	h.push({name:'action',value:'save'});
	h.push({name:'unox',value:Unox});
	for(v=0;v<a.length;v++){
		b+='"'+a[v].name.substr(0,a[v].name.length-3)+'":{"typ":"'+a[v].options[a[v].selectedIndex].value+'","ref":"'+c[v].value+'"},';
	};
	b+='"menuOffset":"'+document.getElementById("fixedLayoutMenu").value+'"';
	h.push({name:'data',value:'{'+b+'}'});
	jQuery.post('uno/plugins/fixed_layout/fixed_layout.php',h,function(r){f_alert(r);});
}
//
function f_color_fixedLayout(f,c){var a=document.getElementById("layoutCol"+c);
	if(f.options[f.selectedIndex].value=='color'){
		a.onclick=null;
		if(a.value.substr(0,1)=='/'||a.value=='')a.value="#203080";
		a.className='co';
		jQuery("#layoutCol"+c+".co").colorPicker();
	}
	else jQuery("#layoutCol"+c).parent().empty().append('<input type="text" id="layoutCol'+c+'" onclick="f_finder_select(\'layoutCol'+c+'\')" value="" />');
}
//
f_load_fixedLayout();