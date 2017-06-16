(function(){

    //学生信息、授课信息、综合实践信息、论文指导信息
    var Basicinfo = {

        /**
         * 学生信息
         */
        //查询所指导的学生信息列表
        queryStuInfo: function(){
            //默认查询条件
            var gradePara = "入学年份";//年级,默认当前年级,研一
            var inerPara = "实习状态";//状态,默认所有状态
            var thesisPara = "开题状态";//状态,默认所有状态
            var passPara = "答辩状态";//状态,默认所有状态

            //获取所有学生信息列表
            var allstuObj = Basicinfo.getAllStudentlist();

            //获取符合条件的学生信息列表
            var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
            //动态加载符合条件的学生列表
            Basicinfo.showStuList(stuObj);

            //筛选结果
            //按年级
            $("#graSelect").change(function(){
                gradePara = $("select[name=graSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });
            //按实习状态
            $("#inerSelect").change(function(){
                inerPara = $("select[name=inerSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });
            //按开题状态
            $("#thesisSelect").change(function(){
                thesisPara = $("select[name=thesisSelect] option").not(function(){ return !this.selected }).text();
                //获取符合条件的学生信息列表
                var stuObj = Basicinfo.getStudentlist(gradePara,inerPara,thesisPara,passPara,allstuObj);
                //动态加载符合条件的学生列表
                Basicinfo.showStuList(stuObj)
            });
            //按答辩状态
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
                var copy = stuObj;
                var select = [];
                if(gradePara == "入学年份") {
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
                if(inerPara == "实习状态") {
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
                if(thesisPara == "开题状态") {
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
                if(passPara == "答辩状态") {
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
        showStuList: function (stuObj) {
            //动态加载页面 -- 显示符合条件的学生列表
            var dom = '';
            // if(stuObj[i].status == "已开题"){
            //     stuObj[i].status = "";

            if (stuObj) {
                for (var i = 0; i < stuObj.length; i++) {

                    dom += "<div class=\"weui-media-box weui-media-box_text\">" +
                        "<a class=\"weui-cell_access\" href=\"stuinfo?stuId=" + stuObj[i].stuid + "&stuInerSta=" + stuObj[i].inerStatus + "&stuThesisSta=" + stuObj[i].thesisStatus + "&stuPassSta=" + stuObj[i].passStatus + "\">" +
                        "<div id=\"stulist\" class=\"stulist weui-cell_access\">" +
                        "<p class=\"weui-media-box__desc\"><span id=\"stu-grade\">" + stuObj[i].grade + "</span>级&nbsp;&nbsp;&nbsp;<span id=\"stu-name\">" + stuObj[i].name + "</span>  " + "<span class='box-line aui-zd'>" + stuObj[i].inerStatus + "</span>" + "<span class='box-line aui-zd'>" + stuObj[i].thesisStatus + "</span>" + "<span class='box-line aui-zd'>" + stuObj[i].passStatus + "</span>" + "</p>" +
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
         *
         * 学年id  学年
         *   1   2015-2016
         *   2   2014-2015
         *   3   2016-2017
         */
        queryTeachWork: function(){

            //默认查询条件,学年,默认取id = 3 , 表示当前学年 ,格式:2016-2017
            var yearPara = 3;

            //获取课程列表
            courselist_term1 = Basicinfo.getCourselist(yearPara,1);//第一学期
            courselist_term2 = Basicinfo.getCourselist(yearPara,2);//第二学期
            //动态加载课程列表
             Basicinfo.showCourseList(courselist_term1,1);//第一学期
             Basicinfo.showCourseList(courselist_term2,2);//第二学期

            //按学年查询
            $("#yearSelect").change(function(){
                //获取筛选条件 -- 学年
                yearPara = $("select[name=yearSelect] option").not(function(){ return !this.selected }).val();
                //获取课程列表
                courselist_term1 = Basicinfo.getCourselist(yearPara,1);//第一学期
                courselist_term2 = Basicinfo.getCourselist(yearPara,2);//第二学期
                //动态加载课程列表
                Basicinfo.showCourseList(courselist_term1,1);//第一学期
                Basicinfo.showCourseList(courselist_term2,2);//第二学期
            });
        },

        /**
         * 获取某学年某学期的授课信息列表
         * @param year_name 学年(查询条件)
         * @param term_name 学期
         * @returns {string} 授课信息列表
         */
        getCourselist: function(year_name,term_name){
            var courseObj = "没有课程信息";//课程列表
            var urlstring =  apiConfig.getCourselist;
            $.ajax({
                type: 'POST',
                async: false,
                data: {year_name: year_name, term_name: term_name },
                url : urlstring,
                dataType: 'json',
                success: function(data){
                    var meta = data.meta;
                    if(meta.code == '0'){
                        courseObj = data.courselist;
                        return courseObj;
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
            return courseObj;
        },
        /**
         * 动态加载课程列表(该学年第一、二学期的所有课程)
         * @param 课程列表对象
         * courseObj 课程列表对象
         * courseObj[i].name        课程名
         * courseObj[i].num         课程编号,eg. 0C706
         * courseObj[i].stu_count   选课人数
         * courseObj[i].hour        课程学时,eg. 48
         * courseObj[i].location    地区,eg. 北京
         * courseObj[i].year_name   学年(查询条件),eg. 2016-2017
         * courseObj[i].term_name   学期(查询条件),eg. 1 或 2
         */
        showCourseList: function(courseObj,term_name){
            //动态加载页面 -- 显示符合条件的课程列表
            var dom = '';
            if(term_name == 1){
                $term_title = "第一学期";
            }else {
                $term_title = "第二学期";
            }
            if(courseObj.length != 0) {//有课程信息

                dom += "<div class=\"mweui-cells__title\"><b>"+$term_title+"</b></div>" +
                         " <div class=\"weui-cells\">" ;

                for (var i = 0; i < courseObj.length; i++) {

                    dom += "<div class=\"weui-cell\">" +
                                "<div class=\"weui-cell__bd\">"+
                                     "<p><span>"+courseObj[i].name+"</span><span class=\"course-item\" style=\"float: right;padding-right: 30px\">"+courseObj[i].hour+"课时</span>"+
                                "</div>" +
                                "<div class=\"weui-cell__ft\" style=\"color: #5facbe;text-decoration: underline\">"+courseObj[i].stu_count+"人</div>"+
                            "</div>";
                }
                dom += "</div>";

            }else{//无课程信息
                dom += "<div class=\"mweui-cells__title\"><b>"+$term_title+"</b></div>" +
                    " <div class=\"weui-cells\">" +
                    "<div class=\"weui-cell\">" +
                    "<div class=\"weui-cell__bd\">"+
                    "<p><span>无课程信息</span><span class=\"course-item\" style=\"float: right;padding-right: 30px\"></span>"+
                    "</div>" +
                    "<div class=\"weui-cell__ft\" style=\"color: #5facbe;text-decoration: underline\"></div>"+
                    "</div>"+
                    "</div>";

            }
            if(term_name == 1){
                $("#coures-term1").html(dom);
            }else {
                $("#coures-term2").html(dom);
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
                        "<p class=\"mweui-media-box__desc\"><span>综合实践:</span> <span>1班</span></p>" +
                        "<ul class=\"weui-media-box__info\">" +
                        "<li class=\"weui-media-box__info__meta\">人数: <span>5</span>人</li>"+
                        "<li class=\"weui-media-box__info__meta\">工作量所占百分比:<span>100</span>%</li>"+
                        "</ul>"+
                        "<ul class=\"weui-media-box__info\">" +
                        "<li class=\"weui-media-box__info__meta\">所属校区: <span>北京</span></li>"+
                        "<li class=\"weui-media-box__info__meta weui-media-box__info__meta_extra\"><span>16-17学年</span></li>"+
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
                        "<p class=\"mweui-media-box__desc\"><span>2017年6月论文答辩</span></p>" +
                        "<ul class=\"weui-media-box__info\">" +
                        "<li class=\"weui-media-box__info__meta\">工作量:<span>13.2</span></li>"+
                        "</ul>"+
                        "<ul class=\"weui-media-box__info\">"+
                    "<li class=\"weui-media-box__info__meta\">通过答辩<span>16</span>人</li>"+
                    "<li class=\"weui-media-box__info__meta weui-media-box__info__meta_extra\"><span>北京</span></li>"+
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