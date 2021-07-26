//搜索效果逻辑实现
new Vue({
    el: "#root",
    data: {
        titleHead: true,
        rightHead: true,
        secSearch: false,
    },
    methods: {
        mobSearStart: function() {
            this.titleHead = false;
            this.rightHead = false;
            this.secSearch = true;
        },
        delectMobSear: function() {
            this.secSearch = false;
            this.titleHead = true;
            this.rightHead = true;
        },
    },
});

//导航栏溢出遮罩显示逻辑
var buts = document.getElementById("mask-father");
window.onload = function() {
    if (buts.offsetWidth != buts.scrollWidth) {
        document.getElementById("mask-show").style.display = "initial";
    } else {
        document.getElementById("mask-show").style.display = "none";
    }
};
window.onresize = function() {
    if (buts.offsetWidth != buts.scrollWidth) {
        document.getElementById("mask-show").style.display = "initial";
    } else {
        document.getElementById("mask-show").style.display = "none";
    }
};

//让i标签可以像input一样提交表单
function formSubmit() {
    document.getElementById("search-bt").submit();
}

/*时间问候语*/
(now = new Date()), (hour = now.getHours());
if (hour < 6) {
    document.getElementById("timetips").innerHTML = "凌晨好~";
} else if (hour < 9) {
    document.getElementById("timetips").innerHTML = "早上好~";
} else if (hour < 12) {
    document.getElementById("timetips").innerHTML = "上午好~";
} else if (hour < 14) {
    document.getElementById("timetips").innerHTML = "中午好~";
} else if (hour < 17) {
    document.getElementById("timetips").innerHTML = "下午好~";
} else if (hour < 19) {
    document.getElementById("timetips").innerHTML = "傍晚好~";
} else if (hour < 22) {
    document.getElementById("timetips").innerHTML = "晚上好~";
} else {
    document.getElementById("timetips").innerHTML = "午夜好~";
}

/*返回顶部*/
function addloadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != "function") {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        };
    }
}
addloadEvent(b);

function b() {
    var gotop = document.getElementById("gotop");
    var timer;
    var tf = true;

    function topif() {
        //页面加载完判断是否显示按钮
        //获取滚动条高度
        var ostop =
            document.documentElement.scrollTop ||
            window.pageYOffset ||
            document.body.scrollTop;
        //获取窗口可视区域高度
        //console.log(ostop)
        var ch =
            document.documentElement.clientHeight || document.body.clientHeight;
        //如果页面超过一屏高度按钮显示，否则隐藏
        if (ostop >= ch) {
            gotop.style.display = "flex";
        } else {
            gotop.style.display = "none";
        }
        //
        if (!tf) {
            clearInterval(timer);
        }
        tf = false;
    }
    topif();
    //滚动触发
    window.onscroll = function() {
        topif();
    };
    //点击触发
    gotop.onclick = function() {
        //创建定时器
        timer = setInterval(function() {
            //获取滚动条高度
            var ostop =
                document.documentElement.scrollTop ||
                window.pageYOffset ||
                document.body.scrollTop;
            //每次上升高度的20%
            var speed = Math.ceil(ostop / 5);
            //每次上升当前高度的80%
            document.documentElement.scrollTop = document.body.scrollTop =
                ostop - speed;
            //如果高度为0，清除定时器
            if (ostop == 0) {
                clearInterval(timer);
            }
            tf = true;
        }, 30);
    };
}

/*图片模糊加载*/
function hasClass(obj, cls) {
    return obj.className.match(new RegExp("(\\s|^)" + cls + "(\\s|$)"));
}

function removeClass(obj, cls) {
    if (hasClass(obj, cls)) {
        var reg = new RegExp("(\\s|^)" + cls + "(\\s|$)");
        obj.className = obj.className.replace(reg, " ");
    }
}
let containers = document.querySelectorAll(".gauss-img");
for (let elem of containers) {
    let qualitySrc = elem.getAttribute("data-src");
    let qualityImg = new Image();
    qualityImg.src = qualitySrc;
    qualityImg.onload = () => {
        removeClass(elem, "gauss-style");
        elem.src = qualitySrc;
    };
}

// 图片懒加载(与模糊加载冲突，只可开一个)

// var imgs = document.querySelectorAll('.pictures');

//         //offsetTop是元素与offsetParent的距离，循环获取直到页面顶部
//         function getTop(e) {
//             var T = e.offsetTop;
//             while(e = e.offsetParent) {
//                 T += e.offsetTop;
//             }
//             return T;
//         }

//         function lazyLoad(imgs) {
//             var H = document.documentElement.clientHeight;//获取可视区域高度
//             var S = document.documentElement.scrollTop || document.body.scrollTop;
//             for (var i = 0; i < imgs.length; i++) {
//                 if (H + S > getTop(imgs[i])) {

//                     imgs[i].src = imgs[i].getAttribute('data-src');
//                 }
//             }
//         }

//         window.onload = window.onscroll = function () { //onscroll()在滚动条滚动的时候触发
//             lazyLoad(imgs);
//         }