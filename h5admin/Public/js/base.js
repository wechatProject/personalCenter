;(function($, window, undefined){

//验证
  var Validate = {
	
	

	
	
	
	
	
  //统一出错弹框提示
  alertError: function(){
    Validate.logout();
    $.dialog({
      content : '出错了，请重新登录',
      title : 'alert',
      ok : function() {
        location.href = "login.html";
        window.localStorage.clear();
      },
      lock : true
    });
  },

};

/*--------------common----------------*/

  $(".go-back").on("click",function(){
    window.history.go(-1);
  });


  var rValidate = function(){
    //noinspection JSUnresolvedFunction
      return new Validate();
  }

  window.Validate = rValidate = Validate;

})(window.jQuery || window.Zepto, window);
