(function(){

    //学生信息、授课信息、综合实践信息、论文指导信息
    var Basicinfo = {

        /**
         * 学生信息
         */
        //查询所指导的学生信息列表
        queryStuInfo: function(){
            //默认查询条件
            var gradePara = "所有年级";//年级,默认当前年级,研一
            var inerPara = "全部实习状态";//状态,默认所有状态
            var thesisPara = "全部开题状态";//状态,默认所有状态
            var passPara = "全部答辩状态";//状态,默认所有状态

            //获取所有学生信息列表
            var allstuObj = Basicinfo.getAllStudentlist();

            //获取符合条件的学生信息列表
            var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
            //动态加载符合条件的学生列表
            Basicinfo.showStuList(stuObj);

            //筛选结果
            $("#graSelect").change(function(){
                gradePara = $("select[name=graSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });

            $("#inerSelect").change(function(){
                inerPara = $("select[name=inerSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });
            $("#thesisSelect").change(function(){
                thesisPara = $("select[name=thesisSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });
            $("#passSelect").change(function(){
                passPara = $("select[name=passSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });
        },
        /**
         * 获取所有的学生信息列表
         * @returns 所有学生列表
         *
         * 获取后的结果同时存入本地存储localStorage.setItem("stuStr",stuStr);使用时需要转为对象
         */
        getAllStudentlist: function(){
            var staObj = "";//所有学生状态列表
            var stuObj = "";//所有学生列表
            //获取所有学生列表和所有状态
            var urlstring =  apiConfig.getAllStduentlist;
            //获取学生列表
            $.ajax({
                type : 'GET',
                async: false,
                url : urlstring,
                dataType: 'json',
                success: function(data){
                    staObj = data.staData;//暂时未用到
                    stuObj = data.stuData;
                    if(!stuObj){//取到数据
                        console.log("未取到学生信息列表!");
                    }else{//未取到数据
                        var meta = data.meta;
                        if(meta.code == '0'){
                            var staStr = JSON.stringify(staObj);//对象转为json字符串,localStorage只支持字符串
                            var stuStr = JSON.stringify(stuObj);
                            localStorage.setItem("staStr",staStr);//暂时未使用到
                            localStorage.setItem("stuStr",stuStr);//暂时未使用到
                        }
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    //提示出错
                    console.log("ajax error");
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
            return stuObj;
        },

        /**
         * 获取符合条件的学生信息列表
         * @param gradePara     年级
         * @param inerSelect    实习状态
         * @param thesisSelect  开题状态
         * @param passSelect    答辩状态
         * @param stuObj        全部学生列表
         * @returns {Array}     符合条件的学生列表
         * 获取后的结果同时存入本地存储localStorage.setItem("stuStr",stuStr);使用时需要转为对象
         */
        getStudentlist: function(gradePara,inerPara,thesisPara,passPara,stuObj){
            //动态加载 - 学生列表 - 使用到的变量
            //stuObj  可将符合条件的学生列表存入(数组对象)
            //stuObj[i].grade
            //stuObj[i].name
            //stuObj[i].researcharea
            //stuObj[i].stuid
            //stuObj[i].status          //当前状态
            //stuObj[i].inerStatus      //实习状态
            //stuObj[i].thesisStatus    //开题状态
            //stuObj[i].passStatus      //答辩通过状态
            //遍历 - 筛选
            if(!stuObj){//学生信息列表为空
                console.log("未取到学生信息列表!");
            }else{//学生信息列表非空

                //筛选 -- 按年级
                copy = stuObj;
                select = [];
                if(gradePara == "所有年级") {
                    select = copy;
                } else {
                    for (var i = 0; i < copy.length; i++) {//添加符合条件的元素 -- 年级
                        if (copy[i].grade == gradePara) {
                            select.push(copy[i]);
                        }
                    }
                }

                //筛选 -- 按实习状态
                copy = select;
                select = [];
                if(inerPara == "全部实习状态") {
                    select = copy;
                } else {
                    for (var i = 0; i < copy.length; i++) {//添加符合条件的元素 -- 实习状态
                        if (copy[i].inerStatus == inerPara) {
                            select.push(copy[i]);
                        }
                    }
                }

                //筛选 -- 按开题状态
                copy = select;
                select = [];
                if(thesisPara == "全部开题状态") {
                    select = copy;
                } else {
                    for (var i = 0; i < copy.length; i++) {//添加符合条件的元素 -- 实习状态
                        if (copy[i].thesisStatus == thesisPara) {
                            select.push(copy[i]);
                        }
                    }
                }

                //筛选 -- 按答辩状态
                copy = select;
                select = [];
                if(passPara == "全部答辩状态") {
                    select = copy;
                } else {
                    for (var i = 0; i < copy.length; i++) {//添加符合条件的元素 -- 实习状态
                        if (copy[i].passStatus == passPara) {
                            select.push(copy[i]);
                        }
                    }
                }

                //查询结果统计说明
                $('#iner-para').html(inerPara);
                $('#thesis-para').html(thesisPara);
                $('#pass-para').html(passPara);
                $('#grade-para').html(gradePara);
                $('#total-num').html(select.length);
            }
            return select;
        },
        /**
         * 动态加载学生列表
         * @param stuObj 学生信息列表对象
         * stuObj  可将符合条件的学生列表存入(数组对象)
         * stuObj[i].grade
         * stuObj[i].name
         * stuObj[i].status
         * stuObj[i].researcharea
         * stuObj[i].stuid
         * stuObj[i].status          //当前状态
         * stuObj[i].inerStatus      //实习状态
         * stuObj[i].thesisStatus    //开题状态
         * stuObj[i].passStatus      //答辩通过状态
         */
        showStuList: function(stuObj){
            //动态加载页面 -- 显示符合条件的学生列表
                var dom = '';
            // if(stuObj[i].status == "已开题"){
            //     stuObj[i].status = "";
            // }
            if (stuObj) {
                    for (var i = 0; i < stuObj.length; i++) {

                        dom += "<div class=\"weui-cells  weui-media-box weui-media-box_text\">" +
                            "<a class=\"weui-cell_access\" href=\"stuinfo?stuId=" + stuObj[i].stuid + "&stuInerSta=" + stuObj[i].inerStatus + "&stuThesisSta=" + stuObj[i].thesisStatus + "&stuPassSta=" + stuObj[i].passStatus + "\">" +
                            "<div id=\"stulist\" class=\"stulist weui-cell_access\">" +
                            "<p class=\"weui-media-box__desc\"><span id=\"stu-grade\">" + stuObj[i].grade + "</span>级&nbsp;&nbsp;&nbsp;<span id=\"stu-name\">" + stuObj[i].name + "</span>  " + "<span class='box-line aui-zd'>" +  stuObj[i].inerStatus +"</span>"+ "<span class='box-line aui-zd'>" +  stuObj[i].thesisStatus +"</span>"+"<span class='box-line aui-zd'>" +  stuObj[i].passStatus +"</span>"+"</p>" +
                            "<ul class=\"mweui-media-box__info\">" +
                            "<li class=\"weui-media-box__info__meta\">研究方向 : <span id=\"researcharea\">" + stuObj[i].researcharea + "</span></li>" +
                            "</ul>" +
                            "</div>" +
                            "</a>" +
                            "</div>";
                    }
                    $("#students").html(dom);
                }
        },




        /**
         * 授课课时工作量
         */
        queryTeachWork: function(){
            courseObj = "123";//测试显示列表
            //动态加载该教师所教授的课程列表
            Basicinfo.showCourseList(courseObj);
        },
        /**
         * 动态加载课程列表
         * @param 课程列表对象
         * courseObj 课程列表对象
         * courseObj[i].name     课程名
         * courseObj[i].stuNum   选课人数
         * courseObj[i].hours    课程学时
         * courseObj[i].year     学年(查询条件)
         * courseObj[i].term     学期(查询条件)
         */
        showCourseList: function(courseObj){
            //动态加载页面 -- 显示符合条件的课程列表
            var dom = '';
            if(courseObj) {
                for (var i = 0; i < courseObj.length; i++) {

                    dom += "<div class=\"weui-media-box weui-media-box_text\">" +
                                "<p class=\"mweui-media-box__desc\">互联网软件开发技术实践</p>" +
                                "<ul class=\"weui-media-box__info\">" +
                                    "<li class=\"weui-media-box__info__meta\">选课人数: 40人</li>"+
                                "</ul>"+
                                "<ul class=\"weui-media-box__info\">" +
                                    "<li class=\"weui-media-box__info__meta\"><span>48课时</span></li>"+
                                    "<li class=\"weui-media-box__info__meta weui-media-box__info__meta_extra\"><span>16-17学年</span> <span>第二学期</span></li>"+
                                "</ul>"+
                             "</div>";
                }
                $("#coures").html(dom);
            }
        },

        /**
         * 综合实践工作量
         */
        queryPracticeWork: function(){
            pracWorkObj = "123";//测试显示列表
            //动态加载综合实践工作量列表
            Basicinfo.showPracinfoList(pracWorkObj);
        },
        /**
         * 动态加载综合实践工作量列表
         * @param pracWorkObj 综合实践工作量对象
         * pracInfoObj[i].work     工作量
         * pracInfoObj[i].year     学年(查询条件)
         * pracInfoObj[i].term     学期(查询条件)
         */
        showPracinfoList: function(pracWorkObj){
            var dom = '';
            if(pracWorkObj) {
                for (var i = 0; i < pracWorkObj.length; i++) {

                    dom += "<div class=\"weui-media-box weui-media-box_text\">" +
                        "<p class=\"mweui-media-box__desc\"><span>16-17</span>学年&nbsp;<span>第二学期</span></p>" +
                        "<ul class=\"weui-media-box__info\">" +
                        "<li class=\"weui-media-box__info__meta\">指导综合实践工作量<span>10</span>人</li>"+
                        "</ul>"+
                        "</div>";
                }
                $("#pracWork").html(dom);
            }
        },


        /**
         * 指导论文工作量
         */
        queryPaperWork: function(){
            paperworkObj = "123";//测试显示列表
            //动态加载通过答辩的学生列表
            Basicinfo.showPaperWorkList(paperworkObj);
        },
        /**
         * 动态加载通过答辩的学生列表
         * @param parworkObj 通过答辩的学生列表对象
         * parworkObj[i].name   学生姓名
         * parworkObj[i].grage  学生年级
         * parworkObj[i].researcharea 方向
         * parworkObj[i].date    答辩时段
         * parworkObj[i].year     学年(查询条件)
         * parworkObj[i].term     时段(查询条件)
         */
        showPaperWorkList: function(paperworkObj){
            var dom = '';
            if(paperworkObj) {
                for (var i = 0; i < paperworkObj.length; i++) {

                    dom += "<div class=\"weui-media-box weui-media-box_text\">" +
                        "<p class=\"mweui-media-box__desc\"><span>2016级</span>&nbsp;&nbsp;<span>张三</span></p>" +
                        "<ul class=\"weui-media-box__info\">" +
                        "<li class=\"weui-media-box__info__meta\">方向:<span>计算机软件开发</span></li>"+
                        "</ul>"+
                        "<ul class=\"weui-media-box__info\">"+
                    "<li class=\"weui-media-box__info__meta\">通过答辩</li>"+
                    "<li class=\"weui-media-box__info__meta weui-media-box__info__meta_extra\">答辩时间 <span>2017年7月</span></li>"+
                    "</ul>"+
                    "</div>";
                }
                $("#paperwork").html(dom);
            }
        },
    };

    var rBasicinfo = function(){
        //noinspection JSUnresolvedFunction
        return new Basicinfo();
    }
    window.Basicinfo = rBasicinfo = Basicinfo;
})(window,Zepto);