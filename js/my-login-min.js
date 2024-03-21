/******************************************
 * My Login
 *
 * Bootstrap 4 Login Page
 *
 * @author          Muhamad Nauval Azhar
 * @uri 			https://nauval.in
 * @copyright       Copyright (c) 2018 Muhamad Nauval Azhar
 * @license         My Login is licensed under the MIT license.
 * @github          https://github.com/nauvalazhar/my-login
 * @version         1.2.0
 *
 * Help me to keep this project alive
 * https://www.buymeacoffee.com/mhdnauvalazhar
 * 
 ******************************************/
 "use strict";$((function(){$("input[type='password'][data-eye]").each((function(t){var e=$(this),a="eye-password-"+t;$("#"+a);e.wrap($("<div/>",{style:"position:relative",id:a})),e.css({paddingRight:60}),e.after($("<div/>",{html:"Show",class:"btn btn-primary btn-sm",id:"passeye-toggle-"+t}).css({position:"absolute",right:10,top:e.outerHeight()/2-12,padding:"2px 7px",fontSize:12,cursor:"pointer"})),e.after($("<input/>",{type:"hidden",id:"passeye-"+t}));var s=e.parent().parent().find(".invalid-feedback");s.length&&e.after(s.clone()),e.on("keyup paste",(function(){$("#passeye-"+t).val($(this).val())})),$("#passeye-toggle-"+t).on("click",(function(){e.hasClass("show")?(e.attr("type","password"),e.removeClass("show"),$(this).removeClass("btn-outline-primary")):(e.attr("type","text"),e.val($("#passeye-"+t).val()),e.addClass("show"),$(this).addClass("btn-outline-primary"))}))})),$(".my-login-validation").submit((function(){var t=$(this);!1===t[0].checkValidity()&&(event.preventDefault(),event.stopPropagation()),t.addClass("was-validated")}))}));