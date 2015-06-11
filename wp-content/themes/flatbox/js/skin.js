/*
 FlatBox color scheme option skin v1.0 | @wpbars(http://www.wpbars.com) | GNU General Public License v2 or later license 
*/
jQuery(function(){
	//set skin
	var theme = jQuery("#themeSwithc"), themeLayout = theme.find(".theme-layout"), themeScheme = theme.find(".theme-scheme");
	themeLayout.on("click","li",function(){
		var self = jQuery(this);
		var layout = self.attr("rel");
		if(self.hasClass('current')) return;
		self.addClass("current").siblings().removeClass('current');
		jQuery("#content").attr("class","site-content "+layout);
		setCookie('css-layout', layout);
	})
	if(getCookie('css-layout')) {
		var layout = getCookie('css-layout');
		jQuery("#content").attr("class","site-content "+layout);
		themeLayout.find(".layout-"+layout).addClass('current').siblings().removeClass('current');
	}
	themeScheme.on("click","li",function(){
		var self = jQuery(this), scheme = self.attr("rel");
		if(self.hasClass('current')) return;
		self.addClass('current').siblings().removeClass('current');
		jQuery("#page").attr("class","hfeed site "+scheme);
		setCookie('css-scheme', scheme);
	})
	if(getCookie('css-scheme')) {
		var scheme = getCookie('css-scheme');
		jQuery("#page").attr("class","hfeed site "+scheme);
		themeScheme.find(".color-"+scheme).addClass('current').siblings().removeClass('current');
	}

})
function setCookie(name,value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name) {
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;
}