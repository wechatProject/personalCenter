;(function($, window, undefined){

//验证
  var Validate = {

  //检查表单是否为空
  emptyCheck: function(elem){
    if (elem != "") {
      return true;
    }else{
      return false;
    }
  },

  //检查登录状态
  isLogin: function(){
    if ( window.localStorage["uid"] && window.localStorage["api_key"] && window.localStorage["secret_key"]) {
      return true;
    }else{
      $.dialog({
        content : '出错了，请重新登录',
        title : 'alert',
        ok : function() {
          location.href="login.html";
        },
        lock : true
      });
      return false;
    }
  },

  //生成sign的方法 -- 对应计算sign的方法在common/utils.php/checkLogin()
  createSign: function(api_key,timestamp){
    return this.encrypt(api_key + timestamp + window.localStorage["secret_key"]);
  },

  // // 加盐加密(手机版加密方式)
  // encrypt: function(data){
  //   return md5('ThisIsPsyCloudBackEnd' + data);
  // },

    // web版加密方式
    encrypt: function(data){
      return md5(data);
    },

  //退出
  logout: function(){
    window.localStorage.clear();
    $.dialog({
      content : '已成功退出',
      title : 'alert',
      ok : function() {
        location.href = "login.html";
      },
      lock : true
    });
  },

  //登陆后校验个人信息是否完全
  isInfoCompleted : function(url){
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    //student/isInfoCompleted
    var urlstring = apiConfig.isInfoCompleted + "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign;
    $.ajax({
      type : 'GET',
      async: false,
      url : urlstring,
      success: function(data){
        console.log(data)


        if (data.meta.code == 0 && data.data.updated == true) {
          if (url != undefined) {
            location.href = url;
          }
        }else{
          $.dialog({
            content : '请先完善个人信息',
            title : 'alert',
            ok : function() {
              location.href = "profile-edit.html";
            },
            lock : true
          });
        }
      },
      error : function (){
        Validate.alertError();
        return false;
      }
    })
  },



  // 进行登陆操作，包含相应的输入检查与验证
  login: function(){
    var username = $.trim($(".username").val());
    //密码加密
    var psw = this.encrypt($.trim($(".pwd").val()));
    // var psw = $.trim($(".pwd").val());

    //进行用户名、密码、验证码验证
    if (this.emptyCheck(username) && this.emptyCheck(psw)) {
        var urlstring = apiConfig.login ; //"http://101.200.132.161:90/psycloud_backend/index.php/Home/User/login";

        $.ajax({
          type : 'POST',
          data:{ username: username, password: psw },
          url : urlstring,
          success: function(data){
            var obj = data.data;
            var meta = data.meta;
            if(meta.code == '0'){
              localStorage.setItem("uid",obj.id);
              localStorage.setItem("api_key",obj.api_key);
              localStorage.setItem("secret_key",obj.secret_key);

              Validate.isInfoCompleted("nav.html");
            }else if(meta.code == '212'){
              $.dialog({
                content : '密码错误',
                title : 'alert',
                ok : function() {},
                lock : true
              });
            }else if(meta.code == '211'){
              $.dialog({
                content : '无该用户或未初始化',
                title : 'alert',
                ok : function() {},
                lock : true
              });
            }
          else{
             Validate.alertError();
           }
         },
         error : function (){
           Validate.alertError();
         }
       })
    }
  },

  //只获取学生信息
  getStudentInfoOnly: function(){
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var urlstring = apiConfig.getStudentInfo;

    $.ajax({
      type : 'GET',
      data:{ api_key: api_key, timestamp: timestamp, sign: sign },
      url : urlstring,
      success: function(data){
        var obj = data.data;
        var meta = data.meta;
        if(meta.code == '0'){
        // console.log("第一步获取的学生基本信息");
        // console.log(obj);
          localStorage.setItem("studata",obj);

          $(".stu-name").html(obj.name);
          $(".stu-major").html(obj.department.name);
          $(".stu-grade").html(obj.grade.name);

          if (!window.localStorage["avatar-id"]) {
            localStorage.setItem("avatar-id",obj.head_pic_id);
          }

          $(".setting-main .avatar").attr("src",apiConfig.pic_url + window.localStorage["avatar-id"] + ".jpg");

        }else{
          Validate.alertError();
        }
      },
      error: function(){
        Validate.alertError();
      }
    })
  },

  //获取学生信息并更新显示
  getStudentInfo: function(){
      var api_key = window.localStorage["api_key"];
      var timestamp = parseInt(new Date().getTime() / 1000) - 600;
      var sign = this.createSign(api_key, timestamp);
      var urlstring = apiConfig.getStudentInfo;

      $.ajax({
        type : 'GET',
        data:{ api_key: api_key, timestamp: timestamp, sign: sign },
        url : urlstring,
        success: function(data){
          var obj = data.data;
          var meta = data.meta;
          if(meta.code == '0'){
            // console.log("第一步获取的学生基本信息");
            // console.log(obj);
            localStorage.setItem("studata",obj);

            $(".stu-name").val(obj.name);
            $(".stu-id").val(obj.student_num);

            if(obj.detail != null && obj.detail.hasOwnProperty("graduate_school") && obj.detail.graduate_school != null){
              $(".graduate").val(obj.detail.graduate_school);
            }else{
              $(".graduate").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["graduate_school"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("dormetry") && obj.detail.dormetry != null){
              $(".stu-dormetry").val(obj.detail.dormetry);
            }else{
              $(".stu-dormetry").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["dormetry"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("ethnic_group") && obj.detail.ethnic_group != null){
              $(".stu-ethnicgroup").val(obj.detail.ethnic_group);
            }else{
              $(".stu-ethnicgroup").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["ethnic_group"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("mail") && obj.detail.mail != null){
              $(".stu-email").val(obj.detail.mail);
            }else{
              $(".stu-email").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["mail"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("address") && obj.detail.address != null){
              $(".stu-address").val(obj.detail.address);
            }else{
              $(".stu-address").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["address"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("cellphone") && obj.detail.cellphone != null){
              $(".stu-cellphone").val(obj.detail.cellphone);
            }else{
              $(".stu-cellphone").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["cellphone"] = '';
            }



            if(obj.detail != null && obj.detail.hasOwnProperty("native_place") && obj.detail.native_place != null){
              $(".native_place").val(obj.detail.native_place.id);
            }else{
              $(".native_place").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["native_place"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("political_status") && obj.detail.political_status != null){
              $(".political_status").val(obj.detail.political_status_id);
            }else{
              $(".political_status").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["political_status"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("religion") && obj.detail.religion_id != null){
              $(".religion").val(obj.detail.religion_id);
            }else{
              $(".religion").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["religion"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("source_area") && obj.detail.source_area != null){
              $(".source_area").val(obj.detail.source_area.id);
            }else{
              $(".source_area").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["source_area"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("parents_marriage_id") && obj.family.parents_marriage_id != null){
              $(".parents_marriage").val(obj.family.parents_marriage_id);
            }else{
              $(".parents_marriage").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["parents_marriage_id"] = '';
            }

          //  native_place

            if(obj.detail != null && obj.detail.hasOwnProperty("is_art_student") && obj.detail.is_art_student != null){
              $(".stu-isartstudent").val(obj.detail.is_art_student);
            }else{
              $(".stu-isartstudent").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["is_art_student"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("is_poor_student") && obj.detail.is_poor_student != null){
              $(".stu-ispoorstudent").val(obj.detail.is_poor_student);
            }else{
              $(".stu-ispoorstudent").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["is_poor_student"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("is_recommended") && obj.detail.is_recommended != null){
              $(".stu-isrecommended").val(obj.detail.is_recommended);
            }else{
              $(".stu-isrecommended").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["is_recommended"] = '';
            }


            if(obj.detail != null && obj.detail.hasOwnProperty("is_recommended_by_contest") && obj.detail.is_recommended_by_contest != null){
              $(".stu-isrecommendedbycontest").val(obj.detail.is_recommended_by_contest);
            }else{
              $(".stu-isrecommendedbycontest").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["is_recommended_by_contest"] = '';
            }

            if(obj.detail != null && obj.detail.hasOwnProperty("telephone") && obj.detail.telephone != null){
              $(".stu-tel").val(obj.detail.telephone);
            }else{
              $(".stu-tel").val('');
              if (obj.detail == null) {
                obj.detail = {};
              }
              obj.detail["telephone"] = '';
            }




            if(obj.family != null && obj.family.hasOwnProperty("emergency_name") && obj.family.emergency_name != null){
              $(".stu-emergencyname").val(obj.family.emergency_name);
            }else{
              $(".stu-emergencyname").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["emergency_name"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("emergency_telephone") && obj.family.emergency_telephone != null){
              $(".stu-emergencytelephone").val(obj.family.emergency_telephone);
            }else{
              $(".stu-emergencytelephone").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["emergency_telephone"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("emergency_relation") && obj.family.emergency_relation != null){
              $(".stu-emergencyrelation").val(obj.family.emergency_relation);
            }else{
              $(".stu-emergencyrelation").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["emergency_relation"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("brother_sister_count") && obj.family.brother_sister_count != null){
              $(".stu-brothersistercount").val(obj.family.brother_sister_count);
            }else{
              $(".stu-brothersistercount").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["brother_sister_count"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("family_rank") && obj.family.family_rank != null){
              $(".stu-familyrank").val(obj.family.family_rank);
            }else{
              $(".stu-familyrank").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["family_rank"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("father_age") && obj.family.father_age != null){
              $(".stu-fatherage").val(obj.family.father_age);
            }else{
              $(".stu-fatherage").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["father_age"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("father_education") && obj.family.father_education != null){
              $(".stu-fathereducation").val(obj.family.father_education);
            }else{
              $(".stu-fathereducation").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["father_education"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("father_profession") && obj.family.father_profession != null){
              $(".stu-fatherprofession").val(obj.family.father_profession);
            }else{
              $(".stu-fatherprofession").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["father_profession"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("father_status") && obj.family.father_status != null){
              $(".stu-fatherstatus").val(obj.family.father_status);
            }else{
              $(".stu-fatherstatus").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["father_status"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("father_telephone") && obj.family.father_telephone != null){
              $(".stu-fathertelephone").val(obj.family.father_telephone);
            }else{
              $(".stu-fathertelephone").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["father_telephone"] = '';
            }



            if(obj.family != null && obj.family.hasOwnProperty("mother_education") && obj.family.mother_education != null){
              $(".stu-mothereducation").val(obj.family.mother_education);
            }else{
              $(".stu-mothereducation").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["mother_education"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("mother_age") && obj.family.mother_age != null){
              $(".stu-motherage").val(obj.family.mother_age);
            }else{
              $(".stu-motherage").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["mother_age"] = '';
            }


            if(obj.family != null && obj.family.hasOwnProperty("mother_profession") && obj.family.mother_profession != null){
              $(".stu-motherprofession").val(obj.family.mother_profession);
            }else{
              $(".stu-motherprofession").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["mother_profession"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("mother_status") && obj.family.mother_status != null){
              $(".stu-motherstatus").val(obj.family.mother_status);
            }else{
              $(".stu-motherstatus").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["mother_status"] = '';
            }

            if(obj.family != null && obj.family.hasOwnProperty("mother_telephone") && obj.family.mother_telephone != null){
              $(".stu-mothertelephone").val(obj.family.mother_telephone);
            }else{
              $(".stu-mothertelephone").val('');
              if (obj.family == null) {
                obj.family = {};
              }
              obj.family["mother_telephone"] = '';
            }


        //    $(".stu-parentsmarriageid").val(obj.family.parents_marriage_id);

            if (!window.localStorage["avatar-id"]) {
              localStorage.setItem("avatar-id",obj.head_pic_id);
            }

            $(".setting-main .avatar").attr("src",apiConfig.pic_url + window.localStorage["avatar-id"] + ".jpg");


            localStorage.setItem("studata",JSON.stringify(obj));
          }else if (meta.code == '403') {
            $.dialog({
              content : '未指定学生ID',
              title : 'alert',
              ok : function() {},
              lock : true
            });
          }else{
            Validate.alertError();
          }
        },
        error: function(){
          Validate.alertError();
        }
      })

  },

  //获取学校options备选项数据
  getSchoolOptions : function(){
  //  this.isLogin();
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var dom = ".stu-school";
    var urlstring = apiConfig.getInfoOptions + "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign + "&model=school" ;

    $.ajax({
      async: false,
      type : 'GET',
      url : urlstring,
      success: function(data){
        console.log("获取options");
        console.log(data);
        if (data.meta.code == "0") {
          var str = "<option value=\"\" selected=\"selected\">请选择</option>";
          for (var j = 0; j < data.data.length; j++) {
            str += "<option value=\"" + data.data[j].id + "\">" + Validate.getOptionsValue(data.data[j]) + "</option>";
            $(dom).html(str);
          }
        }
      },
      error : function (){
        Validate.alertError();
      }
   });

  },

  //获取用户options备选项
  getInfoOptions : function(){
    var options = {
      'native_place' : 'native_place',
      'political_status' : 'political_status',
      'religion' : 'religion',
      'source_area' : 'source_area',
      'parents_marriage' : 'parents_marriage'
    };
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var urlstring = "";
    var dom = "";

    for (var i in options) {
      //General/getOptions
      urlstring = apiConfig.getInfoOptions + "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign + "&model=" + i;
      $.ajax({
        async: false,
        type : 'GET',
        url : urlstring,
        success: function(data){
          // console.log("获取options");
          // console.log(data);
          if (data.meta.code == "0") {
            var str = "<option value=\"\" selected=\"selected\">请选择</option>";
            for (var j = 0; j < data.data.length; j++) {
              str += "<option value=\"" + data.data[j].id + "\">" + Validate.getOptionsValue(data.data[j]) + "</option>";
            }
            dom = "." + i ;
            $(dom).html(str);
          }
        },
        error : function (){
          Validate.alertError();
        }
     })
    }
  },

  //获得option的展现值
  getOptionsValue : function(obj){
    for (var i in obj) {
      if (i != "id" && i != "status") {
        return obj[i];
      }
    }
  },

  //获得option的key值
  getOptionsKey : function(obj){
    for (var i in obj) {
      if (i != "id" && i != "status") {
        return i;
      }
    }
  },

  //用户提交资料是否完全
  checkProfileCompleted : function(){
    var flag = true;
    $(".is-required").each(function(){
    //  console.log($(this));
      if (!$(this).val().replace(/(^\s*)|(\s*$)/g,"")) {
        flag = false;
      }
    });
    return flag;
  },

  //获取订制服务数据
  getSchoolCustomFields :function (){
    //this.isLogin();
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var urlstring =  apiConfig.getSchoolCustomFields+ "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign;

    $.ajax({
      type : 'GET',
      url : urlstring,
      success: function(data){
        if (data.meta.code == "0") {
          Validate.getShowCustom(data.data);
          console.log("获取custom信息");
          console.log(data.data);
        }
      },
      error : function (){
        Validate.alertError();
      }
   })
  },

  //获取需要显示的定制数据ID
  getShowCustom : function(data){
    var showID = Array();
    for (var i in data) {
      if (i.indexOf("show_custom") != -1 && data[i] != null) {
        showID.push(i.replace("show_custom",""));
      }
    }
    if (showID.length != 0) {
      Validate.createCustomFrom(data,showID);
    }
  },

  //生成定制数据表单
  createCustomFrom: function(data,ids){
  //  console.log(data);
    var isRequired = '',
        dom = '';
    for (var i = 0; i < ids.length; i++) {
      if (data["require_custom" + ids[i]] != null) {
        isRequired = " is-required";
      }
      dom += "<div class=\"item  border-bottom\"><div class=\"icon-title item-title \">" + data["custom" + ids[i] + "_label"] + "</div><div class=\"item-control\"><input class=\" " + isRequired + " custom" + ids[i] + " extra-option \"/></div></div>";
    }

    $(".item-list-profile").append(dom);

    var studata = JSON.parse(window.localStorage["studata"]);
    for (var i = 0; i < ids.length; i++) {
      if (studata.detail["custom"+ids[i]] == undefined) {
        studata.detail["custom"+ids[i]] = '';
      }
      $(".custom" + ids[i]).val(studata.detail["custom"+ids[i]]);
    }
  //  console.log(stu);
  },

  //获取自定义字段值传入window.localStorage["studata"]
  editSchoolCustomFields:function(data){
    $(".extra-option").each(function(){
      var className = Array();
      className = $(this).attr('class').split(" ");
      for (var i = 0; i < className.length; i++) {
        if(className[i].indexOf("custom") != -1){
          var key = className[i];
          data.detail[key] = $(this).val();
        }
      }
    });
    return data;
  },

  //提交用户资料修改
  modifyUser : function(){
//    this.isLogin();

    var studata = JSON.parse(window.localStorage["studata"]);
    // this.editSchoolCustomFields(studata);
    console.log("提交修改前第一次从本地获取的studata对象");
    console.log(studata);
  //  console.log(studata);
    studata.department_id = $(".stu-depa").val();
  //  studata.grade_id = $(".stu-grad").val();
    studata.detail.cellphone = $(".stu-cellphone").val();
    studata.detail.graduate_school = $(".graduate").val();
    studata.detail.mail = $(".stu-email").val();
  //  studata.birthday = $(".bir-year").val() + "-" + $(".bir-month").val() + "-" + $(".bir-day").val();
    studata.detail.address = $(".stu-address").val();
    studata.head_pic_id = window.localStorage["avatar-id"];//$(".setting-main .avatar").attr("src");
    studata.detail.dormetry = $(".stu-dormetry").val();
    studata.detail.ethnic_group = $(".stu-ethnicgroup").val();
    studata.detail.mail = $(".stu-email").val();
    studata.detail.address = $(".stu-address").val();

    studata.detail.native_place_id = $(".native_place").val();
    studata.detail.political_status_id = $(".political_status").val();
    studata.detail.religion_id = $(".religion").val();
    studata.detail.source_area_id = $(".source_area").val();
    studata.family.parents_marriage_id = $(".parents_marriage").val();

    studata.detail.is_art_student = $(".stu-isartstudent").val();
    studata.detail.is_poor_student = $(".stu-ispoorstudent").val();
    studata.detail.is_recommended = $(".stu-isrecommended").val();
    studata.detail.is_recommended_by_contest = $(".stu-isrecommendedbycontest").val();
    studata.detail.telephone = $(".stu-tel").val();
    studata.family.emergency_name = $(".stu-emergencyname").val();
    studata.family.emergency_telephone = $(".stu-emergencytelephone").val();
    studata.family.emergency_relation = $(".stu-emergencyrelation").val();
    studata.family.brother_sister_count = $(".stu-brothersistercount").val();
    studata.family.family_rank = $(".stu-familyrank").val();
    studata.family.father_age = $(".stu-fatherage").val();
    studata.family.father_education = $(".stu-fathereducation").val();
    studata.family.father_profession = $(".stu-fatherprofession").val();
    studata.family.father_status = $(".stu-fatherstatus").val();
    studata.family.father_telephone = $(".stu-fathertelephone").val();
    studata.family.mother_age = $(".stu-motherage").val();
    studata.family.mother_education = $(".stu-mothereducation").val();
    studata.family.mother_profession = $(".stu-motherprofession").val();
    studata.family.mother_status = $(".stu-motherstatus").val();
    studata.family.mother_telephone = $(".stu-mothertelephone").val();

    studata = Validate.editSchoolCustomFields(studata);

    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var urlstring =  apiConfig.modifyUser + "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign;
    localStorage.setItem("studata",JSON.stringify(studata));
    console.log("最后post的修改数据");
    console.log(JSON.stringify(studata));
    if (this.checkProfileCompleted()) {
        $.ajax({
          type : 'POST',
          url : urlstring,
          contentType: "application/json",
          dataType : "json",
          data: JSON.stringify(studata),//"{\"family\" : {\"mother_age\" : \"2222\"}}",//"grade_id" : studata.grade_id , "detail.cellphone" : studata.detail.cellphone , "detail.graduate_school" : studata.detail.graduate_school , "detail.mail" : studata.detail.mail , "birthday" : studata.birthday , "detail.address" : studata.detail.address , "family.emergency_name" : studata.family.emergency_name , "family.emergency_telephone" : studata.family.emergency_telephone , "family.emergency_relation" :  studata.family.emergency_relation , "head_pic_id" : window.localStorage["avatar-id"]}),
          success: function(data){
            console.log(data.meta);
            var meta = data.meta;
            var msg = '';
            var url = '';
            if (meta.code == '0') {
              msg = meta.info;
              url = "profile.html";
            }else{
              msg = meta.error;
            }
              $.dialog({
                content : msg,
                title : 'alert',
                ok : function() {
                  localStorage.removeItem("studata");
                  location.href = "profile.html";
                },
                lock : true
              });
            },
          error : function (data){

            Validate.alertError();
          }
       })
    }else{
      $.dialog({
        content : '请填写完整资料',
        title : 'alert',
        ok : function() {},
        lock : true
      });
    }
  },

  //检查注册手机号
  checkMobile : function(mobile){
    var pattern = /^1[34578]\d{9}$/;
    if (pattern.test(mobile)) {
      return true;
    }else{
      return false;
    }
  },

  //注册短信验证码获取
  sendIdentityCode : function(){
    var mobile = $(".telphone").val().replace(/\s/g, "");
    if(Validate.checkMobile(mobile)){
      var urlstring =  apiConfig.sendIdentityCode;   //+ "?mobile=" + mobile;
      $.ajax({
        type : 'POST',
        url : urlstring,
        data: {mobile : mobile},
        success: function(meta){
          console.log(meta);
          meta=meta.meta;
          if (meta.code == '0') {
            var codeTime = 60;
            var timer = setInterval(function(){
              $(".code-btn").html("<span>等待" + codeTime + "秒</span>");
              codeTime --;
              if (codeTime == 0) {
                $(".code-btn").html("<p>获取验证码</p>");
                $(".code-btn p").on("click",function(){
                  Validate.sendIdentityCode();
                });
                clearInterval(timer);
                return;
              }
            },1000);
          }else{
              msg = meta.error;
              $.dialog({
                  content : msg,
                  title : 'alert',
                  ok : function() {},
                  lock : true
              });
          }
        },
        error : function (data){
          Validate.alertError();
        }
     })
   }else{
     $.dialog({
       content : '请输入正确的手机号',
       title : 'alert',
       ok : function() {
       },
       lock : true
     });
   }
  },

  //提交注册信息
  regUser : function(){
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var urlstring =  apiConfig.regUser + "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign;

    if ($(".pwd").val() !== $(".pwd2").val() ) {
      $.dialog({
        content : '两次密码不一致',
        title : 'alert',
        ok : function() {},
        lock : true
      });
    } else {

      if (this.checkProfileCompleted()) {
          $.ajax({
            type : 'POST',
            url : urlstring,
            data: {school_id : $(".stu-school").val() , student_num : $(".stu-num").val() , birthday : $(".birth-year").val() + "-" + $(".birth-month").val() + "-" + $(".birth-day").val() , username : $(".telphone").val() , password : $(".pwd").val(), code : $(".tel-code").val().replace(/\s/g, "")},//JSON.stringify(res),//"{\"family\" : {\"mother_age\" : \"2222\"}}",//"grade_id" : studata.grade_id , "detail.cellphone" : studata.detail.cellphone , "detail.graduate_school" : studata.detail.graduate_school , "detail.mail" : studata.detail.mail , "birthday" : studata.birthday , "detail.address" : studata.detail.address , "family.emergency_name" : studata.family.emergency_name , "family.emergency_telephone" : studata.family.emergency_telephone , "family.emergency_relation" :  studata.family.emergency_relation , "head_pic_id" : window.localStorage["avatar-id"]}),
            success: function(data){
              console.log($(".birth-year").val() + "-" + $(".birth-month").val() + "-" + $(".birth-day").val());
              var meta = data.meta;
              var msg = '';
              var url = '';
              if (meta.code == '0') {
                msg = meta.info;
                url = "login.html";
              }else{
                msg = meta.error;
              }

              $.dialog({
                content : msg,
                title : 'alert',
                ok : function() {
                  location.href = url;
                },
                lock : true
              });

            },
            error : function (data){
            //  console.log(data);
              Validate.alertError();
            }
         })
      }else{
        $.dialog({
          content : '请填写完整资料',
          title : 'alert',
          ok : function() {},
          lock : true
        });
      }
    }
  },

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

  //获取全部待选头像
  getAllHeadPics: function(){
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var urlstring =  apiConfig.getAllHeadPics + "?api_key=" + api_key + "&timestamp=" + timestamp + "&sign=" + sign;
    $.ajax({
      type : 'GET',
      url : urlstring,
      success: function(data){
        console.log(data);
        var dom = '';
        for (var i = 0; i < data.data.length; i++) {
          dom += "<li><img src=\"" + apiConfig.pic_url + data.data[i].id + ".jpg\" class=\"avatar\" data-index=\"" + data.data[i].id + "\"/></li>";

        }
        $(".avatar-list ul").html(dom);

        $(".avatar-list .avatar").on("click",function(){
          console.log('aa');
          $(".avatar-list .avatar").removeClass("selected");
          localStorage.setItem("avatar-id",$(this).attr("data-index"));
          $(this).addClass("selected");
          location.href = "profile-edit.html";
        });
      },
      error : function (){
        Validate.alertError();
      }
   });
  },

  //修改密码
  modifyPassword: function(){
    var api_key = window.localStorage["api_key"];
    var timestamp = parseInt(new Date().getTime() / 1000) - 600;
    var sign = this.createSign(api_key, timestamp);
    var old_psw ='';
    var new_psw = '';

    //var urlstring = "http://101.200.132.161:90/psycloud_backend/index.php/Home/User/modifyPassword";
    $.ajax({
      type : 'POST',
      url : urlstring,

      data:{ api_key: api_key, timestamp: timestamp, sign: sign,old_psw: old_psw, new_psw: new_psw },
      success: function(data){
        var obj = JSON.parse(data).data;
        var meta = JSON.parse(data).meta;
        var msg = '';
        if(meta.code == '0'){
          msg = '修改密码成功';
        }else{
          msg = meta.error;
        }
        $.dialog({
          content : msg,
          title : 'ok',
          ok : function() {},
          lock : true
        });
      },
      error : function (){
        Validate.alertError();
      }
    })
  },

  //获取年份
  getYearOptions : function(){
    var str = "<option value=\"\" selected=\"selected\">出生年</option>";
    for (var i = 1980; i < 2017; i++) {
      str += "<option value=\"" + i +"\" >" + i + "</option>";
    }
    $(".birth-year").html(str);

    Validate.getMonthOptions();
  },

  //获取月份
  getMonthOptions : function(){
    var str = "<option value=\"\" selected=\"selected\">出生月</option>";
    for (var i = 1; i < 13; i++) {
      if (i < 10) {
        var val = "0" + i;
      }else {
        var val = i;
      }
      str += "<option value=\"" + val +"\" >" + val + "</option>";
    }
    $(".birth-month").html(str);
  },

  //获取天
  getDayOptions : function(year,month){
    if (year !="" && month !="") {
      var daynum = 30;
      var str = "<option value=\"\" selected=\"selected\">出生日</option>";

      if (month == "01" || month == "03"  || month == "05"  || month== "07"  || month == "08"  || month == "10"  || month == "12" ) {
        daynum = 31;
      }else if(month == "02"){
        if ((year % 4 == 0 && year % 100 != 0)|| year % 400 == 0) {
          daynum = 29;
        }else{
          daynum = 28;
        }
      }

      for (var i = 1; i <= daynum; i++) {
        if (i < 10) {
          var val = "0" + i;
        }else {
          var val = i;
        }
        str += "<option value=\"" + val +"\" >" + val + "</option>";
      }
      $(".birth-day").html(str);
    }

  },
};

/*--------------common----------------*/

  $(".go-back").on("click",function(){
    window.history.go(-1);
  });

  $(".logout").on("click",function(){
    Validate.logout();
  });

  var rValidate = function(){
    //noinspection JSUnresolvedFunction
      return new Validate();
  }

  window.Validate = rValidate = Validate;

})(window.jQuery || window.Zepto, window);
