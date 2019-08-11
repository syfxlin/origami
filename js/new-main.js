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
  } else {
    xhr.open(options.type, options.url, options.async);
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
    let el = document.getElementById("scroll-top");
    el.style.transition = "opacity 0.5s";
    if (window.scrollY > 50) {
      el.style.opacity = "1";
    } else {
      el.style.opacity = "0";
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
    let el = document.getElementsByClassName("ori-search")[0];
    el.style.display = "block";
    document.getElementById("ori-search-input").focus();
    el.style.transition = "opacity 0.5s";
    el.style.opacity = "1";
  });
  document
    .getElementById("ori-h-search-close")
    .addEventListener("click", function() {
      let el = document.getElementsByClassName("ori-search")[0];
      setTimeout(function() {
        el.style.display = "none";
      }, 500);
      el.style.transition = "opacity 0.5s";
      el.style.opacity = "0";
    });
};

origami.realTimeSearch = function() {
  let page = 1;
  let ele = document.getElementById("ori-search-input");
  let listEle = document.getElementById("search-list");
  let timer = null;
  let changeSearchList = function(list) {
    listEle.innerHTML = "";
    list.forEach(function(item) {
      let str = "";
      str += '<article class="card" id="post-' + item.id + '">';
      str += '<div class="card-header post-info">';
      str += '<h2 class="card-title">';
      str += '<a href="' + item.link + '">' + item.title.rendered + "</a>";
      str += "</h2>";
      let d = new Date(item.date);
      let dStr =
        d.getFullYear() + "年" + d.getMonth() + "月" + d.getDate() + "日";
      str +=
        '<div class="card-subtitle text-gray"><time>' + dStr + "</time></div>";
      str += "</div>";
      str += '<div class="card-body">' + item.excerpt.rendered + "</div>";
      str += '<div class="card-footer"><div class="post-tags"></div>';
      str += '<a class="read-more" href="' + item.link + '">阅读更多</a>';
      str += "</div>";
      listEle.innerHTML += str;
    });
  };

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

origami.tools = {
  showToast: function(massage, status) {
    let className = "toast-" + status;
    let toast = document.querySelector(".ori-tools .toast");
    toast.classList.add(className);
    toast.querySelector("p").innerHTML = massage;
    toast.style.visibility = "visible";
    toast.style.opacity = "1";
  },
  hideToast: function() {
    let toast = document.querySelector(".ori-tools .toast");
    toast.style.opacity = "0";
    setTimeout(function() {
      toast.style.visibility = "hidden";
      toast.className = "toast";
      toast.querySelector("p").innerHTML = "";
    }, 500);
  },
  initToast: function() {
    document
      .querySelector(".ori-tools .toast .btn-clear")
      .addEventListener("click", function() {
        origami.tools.hideToast();
      });
  }
};

origami.initComments = function() {
  let listEle = document.getElementById("comments-list");
  let nav = document.getElementsByClassName("comments-nav")[0];
  let select = document.getElementById("comments-select");
  let nextBtn = document.getElementById("comments-next");
  let prevBtn = document.getElementById("comments-prev");
  let isOne = true;
  let postId = listEle.getAttribute("data-postid");
  let pageCount = listEle.getAttribute("data-pagecount");
  let pageOut = 1;
  let commentToHtml = function(item, lv = 1) {
    let str = "";
    str +=
      '<div id="comment-' +
      item.comment_ID +
      '" class="comment-lv' +
      lv +
      ' comment-item">';
    str += item.comment_avatar;
    str += '<div class="comment-content"><div class="comment-header">';
    if (item.comment_author_url == "") {
      str += '<div class="comment-author">' + item.comment_author + "</div>";
    } else {
      str +=
        '<div class="comment-author"><a href="' +
        item.comment_author_url +
        '">' +
        item.comment_author +
        "</a></div>";
    }
    str += item.comment_mark;
    if (item.comment_approved != "1") {
      str += '<div class="not-approved">您的评论还在等待审核</div>';
    }
    str += "</div>";
    str += '<div class="comment-body">' + item.comment_content + "</div>";
    str += '<div class="comment-footer">';
    str +=
      '<div class="comment-date"><i class="fa fa-clock-o" aria-hidden="true"></i>';
    str += "发表于: <time>" + item.comment_date + "</time></div>";
    str += '<div class="comment-btn"><span title="回复">';
    str += '<i class="fa fa-reply" aria-hidden="true"></i>';
    str +=
      '<a rel="nofollow" class="comment-reply-link" data-commentid="' +
      item.comment_ID +
      '" data-postid="' +
      item.comment_post_ID +
      '">回复</a>';
    str += "</span></div></div></div></div>";
    return str;
  };
  let changeComments = function(list, lv = 1) {
    let str = "";
    list.forEach(function(item) {
      str += commentToHtml(item, lv);
      if (item.sub != []) {
        str +=
          '<ul class="comment-children">' +
          changeComments(item.sub, lv + 1) +
          "</ul>";
      }
    });
    return str;
  };
  let changeNav = function() {
    if (pageOut == 1) {
      prevBtn.style.display = "none";
    } else {
      prevBtn.style.display = "block";
    }
    if (pageOut == pageCount) {
      nextBtn.style.display = "none";
    } else {
      nextBtn.style.display = "block";
    }
    select.value = pageOut;
  };
  let load = function(page = -1, callback = () => {}) {
    if (page == -1) {
      page = pageOut;
    }
    let loading = document.getElementById("comments-loading");
    if (!isOne) {
      window.scrollTo({
        top: loading.offsetTop - 200,
        behavior: "smooth"
      });
    }
    loading.style.height = "4rem";
    listEle.style.height = "0px";
    if (page <= 0) {
      page = 1;
    }
    if (page > pageCount) {
      page = pageCount;
    }
    let loadF = function() {
      $http({
        url: "/wp-json/origami/v1/comments",
        type: "GET",
        dataType: "json",
        data: {
          id: postId,
          page: page
        },
        success: function(response) {
          loading.style.height = "0";
          listEle.innerHTML = changeComments(response);
          listEle.style.height = listEle.scrollHeight + "px";
          setTimeout(function() {
            listEle.style.height = "unset";
          }, 600);
          pageOut = page;
          changeNav();
          callback(pageOut, response);
        },
        error: function(status) {
          console.log("状态码为" + status);
        }
      });
    };
    if (isOne) {
      loadF();
      isOne = false;
    } else {
      setTimeout(loadF, 600);
    }
  };
  let loadPrev = function() {
    pageOut--;
    load(pageOut);
  };
  let loadNext = function() {
    pageOut++;
    load(pageOut);
  };
  let submit = function(info, callback = () => {}) {
    $http({
      url: "/wp-json/origami/v1/comments",
      type: "POST",
      dataType: "json",
      data: {
        author_email: info.author_email,
        author_name: info.author_name,
        author_url: info.author_url,
        content: info.content,
        parent: info.parent,
        post: info.post
      },
      success: function(res) {
        callback(res);
      },
      error: function(error) {
        console.log("状态码为" + status);
      }
    });
  };
  let submitError = function(res) {
    origami.tools.showToast(res.massage, "error");
    setTimeout(origami.tools.hideToast, 5000);
  };
  let submitSuccess = function(res) {
    origami.tools.showToast("评论成功ヾ(≧▽≦*)o", "success");
    setTimeout(origami.tools.hideToast, 5000);
    document.getElementById("response-text").value = "";
    let newComment = new DOMParser()
      .parseFromString(commentToHtml(res), "text/html")
      .getElementsByClassName("comment-item")[0];
    let responseForm = document.getElementById("comments-form");
    let respondMain = document.getElementById("comments-response");
    let parent = responseForm.parentElement;
    if (parent.id == "comments-response") {
      listEle.insertBefore(newComment, listEle.firstChild);
    } else {
      parent.replaceChild(newComment, responseForm);
      respondMain.appendChild(responseForm);
    }
  };
  // 初始化
  let initNav = function() {
    if (pageCount <= 1) {
      return;
    } else {
      nav.style.display = "flex";
    }
    let str = "";
    for (let i = 1; i <= pageCount; i++) {
      str += '<option value="' + i + '">第' + i + "页</option>";
    }
    select.innerHTML = str;
    select.addEventListener("change", function() {
      load(select.value);
    });
    nextBtn.addEventListener("click", loadNext);
    prevBtn.addEventListener("click", loadPrev);
  };
  let initSubmit = function() {
    new SMValidator("form");
    let submitEle = document.getElementById("response-submit");
    submitEle.addEventListener("click", function(e) {
      let loadingEle = document.getElementsByClassName("response-loading")[0];
      let authorNameEle = document.getElementById("response-author");
      let authorEmailEle = document.getElementById("response-email");
      let contentEle = document.getElementById("response-text");
      if (
        contentEle.style.color ||
        authorEmailEle.style.color ||
        authorNameEle.style.color
      ) {
        console.log("输入有误");
        return;
      }
      let info = {
        post: submitEle.getAttribute("data-postid"),
        parent: submitEle.getAttribute("data-commentid"),
        content: contentEle.value,
        author_email: authorEmailEle.value,
        author_name: authorNameEle.value,
        author_url: document.getElementById("response-website").value
      };
      loadingEle.style.opacity = "1";
      submit(info, function(res) {
        loadingEle.style.opacity = "0";
        if (res.code) {
          submitError(res);
          return;
        }
        submitSuccess(res);
      });
      e.preventDefault();
    });
  };
  let initReply = function() {
    let response = document.getElementById("comments-response");
    let form = document.getElementById("comments-form");
    let submitEle = document.getElementById("response-submit");
    let closeResponse = document.getElementById("close-response");
    closeResponse.addEventListener("click", function() {
      form.remove();
      response.appendChild(form);
      submitEle.setAttribute("data-commentid", 0);
      closeResponse.style.visibility = "hidden";
    });
    document.querySelectorAll(".comment-reply-link").forEach(function(item) {
      item.addEventListener("click", function() {
        let parentId = item.getAttribute("data-commentid");
        form.remove();
        document
          .querySelector("#comment-" + parentId)
          .nextElementSibling.appendChild(form);
        submitEle.setAttribute("data-commentid", parentId);
        closeResponse.style.visibility = "visible";
      });
    });
  };
  let init = function() {
    initNav();
    load(-1, function() {
      initReply();
    });
    initSubmit();
  };
  init();
  return {
    load: load,
    loadPrev: loadPrev,
    loadNext: loadNext,
    submit: submit
  };
};

window.addEventListener("load", function() {
  origami.comments = origami.initComments();
  origami.titleChange();
  origami.scrollTop();
  origami.scrollChange();
  origami.mobileBtn();
  origami.searchBtn();
  origami.realTimeSearch();
  origami.tools.initToast();
});
