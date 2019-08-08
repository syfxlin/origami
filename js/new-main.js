window.$httpGetParams = function(data) {
  var arr = [];
  for (var param in data) {
    arr.push(encodeURIComponent(param) + "=" + encodeURIComponent(data[param]));
  }
  return arr.join("&");
};

window.$http = function(options) {
  options = options || {};
  options.type = (options.type || "GET").toUpperCase();
  options.dataType = options.dataType || "json";
  if (options.async === undefined) {
    options.async = true;
  }
  var params = window.$httpGetParams(options.data);
  var xhr;
  if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
  } else {
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      var status = xhr.status;
      if (status >= 200 && status < 300) {
        if (options.dataType === "json") {
          options.success && options.success(JSON.parse(xhr.responseText));
        } else {
          options.success && options.success(xhr.responseText);
        }
      } else {
        options.error && options.error(status);
      }
    }
  };
  if (options.type == "GET") {
    xhr.open("GET", options.url + "?" + params, options.async);
    xhr.send(null);
  } else if (options.type == "POST") {
    xhr.open("POST", options.url, options.async);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(params);
  }
};

var origami = {};

origami.titleChange = function() {
  var origin = document.title;
  var titleTime;
  document.addEventListener("visibilitychange", function() {
    if (document.hidden) {
      document.title = "(つェ⊂)我藏好了哦~ " + origin;
      clearTimeout(titleTime);
    } else {
      document.title = "(*´∇｀*) 被你发现啦~ " + origin;
      titleTime = setTimeout(function() {
        document.title = origin;
      }, 2000);
    }
  });
};

origami.scrollTop = function() {
  let scrollE = function() {
    if (window.scrollY > 50) {
      anime({
        targets: "#scroll-top",
        opacity: 1,
        duration: 1000
      });
    } else {
      anime({
        targets: "#scroll-top",
        opacity: 0,
        duration: 1000
      });
    }
  };
  scrollE();
  window.addEventListener("scroll", scrollE);
  document.getElementById("scroll-top").addEventListener("click", function() {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });
};

origami.scrollChange = function() {
  if (!document.body.classList.contains("home")) return;
  let target =
    document.getElementsByClassName("carousel")[0].clientHeight -
    document.getElementsByClassName("ori-header")[0].clientHeight;
  let scrollE = function() {
    if (window.scrollY >= target) {
      document.body.classList.add("not-car");
    } else {
      document.body.classList.remove("not-car");
    }
  };
  scrollE();
  window.addEventListener("scroll", scrollE);
};

origami.mobileBtn = function() {
  document.getElementById("ori-h-m-btn").addEventListener("click", function() {
    let btn = document.getElementById("ori-h-m-btn");
    let menu = document.getElementById("ori-h-menu");
    let header = document.getElementsByClassName("ori-header")[0];
    if (btn.classList.contains("active")) {
      btn.classList.remove("active");
      menu.classList.remove("active");
      header.classList.remove("menu-active");
    } else {
      btn.classList.add("active");
      menu.classList.add("active");
      header.classList.add("menu-active");
    }
  });
};

origami.searchBtn = function() {
  document.getElementById("ori-h-search").addEventListener("click", function() {
    document.getElementsByClassName("ori-search")[0].style.display = "block";
    document.getElementById("ori-search-input").focus();
    anime({
      targets: ".ori-search",
      opacity: 1,
      duration: 3000
    });
  });
  document
    .getElementById("ori-h-search-close")
    .addEventListener("click", function() {
      anime({
        targets: ".ori-search",
        opacity: 0,
        duration: 3000,
        complete: function() {
          document.getElementsByClassName("ori-search")[0].style.display =
            "none";
        }
      });
    });
};

origami.realTimeSearch = function() {
  let page = 1;
  let ele = document.getElementById("ori-search-input");
  let listEle = document.getElementById("search-list");
  let timer = null;
  let changeSearchList = function(list) {
    listEle.innerHTML = "";
    let c = function(tag) {
      return document.createElement(tag);
    };
    list.forEach(function(item) {
      let post = c("article");
      post.className = "card";
      post.id = "post-" + item.id;
      let header = c("div");
      header.className = "card-header post-info";
      let title = c("h2");
      title.className = "card-title";
      let titleA = c("a");
      titleA.href = item.link;
      titleA.innerHTML = item.title.rendered;
      let subtitle = c("div");
      subtitle.className = "card-subtitle text-gray";
      let time = c("time");
      let d = new Date(item.date);
      time.textContent = d.getFullYear() + "年" + d.getMonth() + "月" + d.getDate() + "日";
      let body = c("div");
      body.className = "card-body";
      body.innerHTML = item.excerpt.rendered;
      let footer = c("div");
      footer.className = "card-footer";
      let tags = c("div");
      tags.className = "post-tags";
      let readMore = c("a");
      readMore.className = "read-more";
      readMore.href = item.link;
      readMore.textContent = "阅读更多";
      
      subtitle.append(time);
      title.append(titleA);
      header.append(title);
      header.append(subtitle);
      footer.append(tags);
      footer.append(readMore);
      post.append(header);
      post.append(body);
      post.append(footer);
      listEle.append(post);
    });
  }

  ele.addEventListener("input", function() {
    clearTimeout(timer);
    timer = setTimeout(function() {
      if (ele.value == "") {
        listEle.innerHTML = "";
        return;
      }
      $http({
        url: "/wp-json/wp/v2/posts",
        type: "GET",
        dataType: "json",
        data: {
          search: ele.value,
          page: page
        },
        success: function(response) {
          changeSearchList(response);
        },
        error: function(status) {
          console.log("状态码为" + status);
        }
      });
    }, 300);
  });
};

window.addEventListener("load", function() {
  origami.titleChange();
  origami.scrollTop();
  origami.scrollChange();
  origami.mobileBtn();
  origami.searchBtn();
  origami.realTimeSearch();
});
