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

window.$getCookie = function(name) {
  var arr,
    reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
  if ((arr = document.cookie.match(reg))) return unescape(arr[2]);
  else return null;
};

window.$getQuery = function(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  }
  return false;
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
  let title = document.getElementById("ori-title");
  let logo = document.getElementById("ori-logo");
  let scrollE = function() {
    if (window.scrollY >= target) {
      document.body.classList.add("not-car");
      title.style.display = "none";
      logo.style.display = "flex";
    } else {
      document.body.classList.remove("not-car");
      title.style.display = "block";
      logo.style.display = "none";
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
  timeToast: function(massage, status, delay) {
    origami.tools.showToast(massage, status);
    setTimeout(origami.tools.hideToast, delay);
  },
  initToast: function() {
    document
      .querySelector(".ori-tools .toast .btn-clear")
      .addEventListener("click", function() {
        origami.tools.hideToast();
      });
  },
  showModal: function(title, content, confirm = () => {}, cancel = () => {}) {
    let modal = document.querySelector(".ori-tools .modal");
    modal.querySelector(".modal-title").textContent = title;
    modal.querySelector(".modal-body .content").textContent = content;
    let confirmEle = modal.querySelector(".confirm");
    let confirmFun = function(e) {
      confirm(e);
      origami.tools.hideModal();
      confirmEle.removeEventListener("click", confirmFun);
    };
    confirmEle.addEventListener("click", confirmFun);
    let cancelEle = modal.querySelector(".cancel");
    let cancelFun = function(e) {
      cancel(e);
      origami.tools.hideModal();
      cancelEle.removeEventListener("click", cancelFun);
    };
    cancelEle.addEventListener("click", cancelFun);
    modal.classList.add("active");
    modal.style.visibility = "visible";
  },
  hideModal: function() {
    let modal = document.querySelector(".ori-tools .modal");
    modal.style.visibility = "hidden";
    modal.classList.remove("active");
  }
};

origami.initComments = function() {
  let listEle = document.getElementById("comments-list");
  if (!listEle) return;
  let nav = document.getElementsByClassName("comments-nav")[0];
  let select = document.getElementById("comments-select");
  let nextBtn = document.getElementById("comments-next");
  let prevBtn = document.getElementById("comments-prev");
  let isOne = true;
  let postId = listEle.getAttribute("data-postid");
  let pageCount = listEle.getAttribute("data-pagecount");
  let pageOut = 1;

  let enUpdate = listEle.getAttribute("data-update") == "true";
  let enDelete = listEle.getAttribute("data-delete") == "true";
  let commentToHtml = function(item, lv = 1, option = {}) {
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
    if (option.enCountdown) {
      str += '<div class="countdown">可操作剩余时间：<span></span></div>';
    }
    if (item.comment_approved != "1") {
      str += '<div class="not-approved">您的评论还在等待审核</div>';
    }
    str += "</div>";
    str += '<div class="comment-body">' + item.comment_content + "</div>";
    str += '<div class="comment-footer">';
    str +=
      '<div class="comment-date"><i class="fa fa-clock-o" aria-hidden="true"></i>';
    str += "发表于: <time>" + item.comment_date + "</time></div>";
    str += '<div class="comment-btn">';
    if (option.enUpdate) {
      str += '<span title="修改"><i class="fa fa-edit"></i>';
      str +=
        '<a rel="nofollow" class="comment-update-link" data-commentid="' +
        item.comment_ID +
        '" data-postid="' +
        item.comment_post_ID +
        '" data-lv="' +
        lv +
        '">修改</a>';
      str += "</span>";
    }
    if (option.enDelete) {
      str += '<span title="删除"><i class="fa fa-trash"></i>';
      str +=
        '<a rel="nofollow" class="comment-delete-link" data-commentid="' +
        item.comment_ID +
        '" data-postid="' +
        item.comment_post_ID +
        '" data-lv="' +
        lv +
        '">删除</a>';
      str += "</span>";
    }
    str += '<span title="回复"><i class="fa fa-reply"></i>';
    str +=
      '<a rel="nofollow" class="comment-reply-link" data-commentid="' +
      item.comment_ID +
      '" data-postid="' +
      item.comment_post_ID +
      '" data-lv="' +
      lv +
      '">回复</a>';
    str += "</span>";
    str += "</div></div></div></div>";
    return str;
  };
  let commentsToList = function(list, lv = 1) {
    let str = "";
    list.forEach(function(item) {
      str += commentToHtml(item, lv);
      if (item.sub != []) {
        str +=
          '<ul class="comment-children">' +
          commentsToList(item.sub, lv + 1) +
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
          listEle.innerHTML = commentsToList(response);
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
  let submit = function(info, callback = () => {}, isUpdate = false) {
    if (!isUpdate) {
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
    } else {
      $http({
        url: "/wp-json/origami/v1/comments",
        type: "PUT",
        dataType: "json",
        data: {
          author_email: info.author_email,
          author_name: info.author_name,
          author_url: info.author_url,
          content: info.content,
          id: info.parent,
          post: info.post
        },
        success: function(res) {
          callback(res);
        },
        error: function(error) {
          console.log("状态码为" + status);
        }
      });
    }
  };
  let submitError = function(res) {
    origami.tools.timeToast(res.massage, "error", 5000);
  };
  let submitSuccess = function(res, lv = 1) {
    // 显示和定时隐藏提示
    origami.tools.timeToast("评论成功ヾ(≧▽≦*)o", "success", 3000);
    // 清空评论框中的值
    document.getElementById("response-text").value = "";
    // 构造新的comment节点
    let newComment = new DOMParser()
      .parseFromString(
        commentToHtml(res, lv, {
          enDelete: enDelete,
          enUpdate: enUpdate,
          enCountdown: true
        }),
        "text/html"
      )
      .getElementsByClassName("comment-item")[0];
    let time = $getCookie("change_comment_time");
    let countdown = setInterval(function() {
      let last = parseInt(time) - Math.round(Date.now() / 1000);
      if (last == 0) {
        clearInterval(countdown);
        newComment.querySelector(".comment-update-link").parentElement.remove();
        newComment.querySelector(".comment-delete-link").parentElement.remove();
        newComment.querySelector(".countdown").remove();
      }
      newComment.querySelector(".countdown span").textContent = last;
    }, 1000);
    let responseForm = document.getElementById("comments-form");
    let respondMain = document.getElementById("comments-response");
    let parent = responseForm.parentElement;
    if (parent.id == "comments-response") {
      listEle.insertBefore(newComment, listEle.firstChild);
    } else {
      parent.replaceChild(newComment, responseForm);
      respondMain.appendChild(responseForm);
    }
    // 初始化两个按钮
    initBtn();
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
      submit(
        info,
        function(res) {
          loadingEle.style.opacity = "0";
          if (res.code) {
            submitError(res);
            return;
          }
          submitSuccess(res, submitEle.getAttribute("data-lv"));
        },
        submitEle.getAttribute("data-isupdate") == "true"
      );
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
      submitEle.setAttribute("data-lv", 1);
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
        submitEle.setAttribute(
          "data-lv",
          parseInt(item.getAttribute("data-lv")) + 1
        );
        closeResponse.style.visibility = "visible";
      });
    });
  };
  let initBtn = function() {
    let deleteBtn = document.getElementsByClassName("comment-delete-link")[0];
    deleteBtn.addEventListener("click", function() {
      origami.tools.showModal("删除评论", "确定要删除这条评论？", function() {
        $http({
          url: "/wp-json/origami/v1/comments",
          type: "DELETE",
          dataType: "json",
          data: {
            id: deleteBtn.getAttribute("data-commentid")
          },
          success: function(res) {
            if (res || res == "true") {
              document
                .getElementById(
                  "comment-" + deleteBtn.getAttribute("data-commentid")
                )
                .remove();
              origami.tools.timeToast("删除评论成功！", "success", 3000);
            }
          }
        });
      });
    });

    let updateBtn = document.getElementsByClassName("comment-update-link")[0];
    updateBtn.addEventListener("click", function() {
      let form = document.getElementById("comments-form");
      let submitEle = document.getElementById("response-submit");
      let closeResponse = document.getElementById("close-response");
      let commentId = updateBtn.getAttribute("data-commentid");
      let commentEle = document.getElementById("comment-" + commentId);
      submitEle.setAttribute("data-commentid", commentId);
      submitEle.setAttribute(
        "data-lv",
        parseInt(updateBtn.getAttribute("data-lv"))
      );
      submitEle.setAttribute("data-isupdate", "true");
      let parent = commentEle.parentElement;
      let next = commentEle.nextElementSibling;
      form.remove();
      parent.replaceChild(form, commentEle);
      document.getElementById("response-text").value = commentEle.querySelector(
        ".comment-body"
      ).innerHTML;
      closeResponse.style.visibility = "visible";
      let repl = function() {
        parent.insertBefore(commentEle, next);
        document.getElementById("response-text").value = "";
        submitEle.removeAttribute("data-isupdate");
        closeResponse.removeEventListener("click", repl);
      };
      closeResponse.addEventListener("click", repl);
    });
  };
  let init = function() {
    let commentPage = $getQuery("comment_page");
    if (commentPage) {
      pageOut = commentPage;
    }
    initNav();
    load(-1, function() {
      if (window.location.hash != "") {
        setTimeout(function() {
          window.scrollTo({
            top: document.querySelector(window.location.hash).offsetTop
          });
        }, 500);
      }
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

origami.loadOwO = function() {
  if (window.is_owo && document.querySelector(".OwO")) {
    new OwO({
      logo: "OωO表情",
      container: document.getElementsByClassName("OwO")[0],
      target: document.getElementById("response-text"),
      api: location.origin + "/wp-content/themes/Origami/js/OwO.json",
      position: "down",
      width: "100%",
      maxHeight: "250px"
    });
  }
};

origami.buildFooterTime = function() {
  if (!window.footerTime) return;
  var now = new Date();
  function createtime() {
    var grt = new Date(window.footerTime);
    now.setTime(now.getTime() + 250);
    days = (now - grt) / 1000 / 60 / 60 / 24;
    dnum = Math.floor(days);
    hours = (now - grt) / 1000 / 60 / 60 - 24 * dnum;
    hnum = Math.floor(hours);
    if (String(hnum).length == 1) {
      hnum = "0" + hnum;
    }
    minutes = (now - grt) / 1000 / 60 - 24 * 60 * dnum - 60 * hnum;
    mnum = Math.floor(minutes);
    if (String(mnum).length == 1) {
      mnum = "0" + mnum;
    }
    seconds =
      (now - grt) / 1000 - 24 * 60 * 60 * dnum - 60 * 60 * hnum - 60 * mnum;
    snum = Math.round(seconds);
    if (String(snum).length == 1) {
      snum = "0" + snum;
    }
    document.getElementById("timeDate").innerHTML = "" + dnum + "天";
    document.getElementById("times").innerHTML =
      hnum + "小时" + mnum + "分" + snum + "秒";
  }
  setInterval(createtime, 250);
};

origami.initTocbot = function() {
  let content = document.querySelector(".s-post-content,.p-post-content");
  let i = 0;
  content.querySelectorAll("h1, h2, h3").forEach(function(item) {
    item.id = "title-" + i;
    i++;
  });
  let offset = document.querySelector(".ori-header").clientHeight;
  tocbot.init({
    tocSelector: ".toc",
    contentSelector: ".s-post-content,.p-post-content",
    headingSelector: "h1, h2, h3",
    onClick: function(e) {
      window.scrollTo({
        top: document.querySelector(e.target.hash).offsetTop - offset - 20,
        behavior: "smooth"
      });
      e.stopPropagation();
      return false;
    }
  });
};

origami.readingTransfer = function() {
  let url = encodeURI(location.href);
  let select = true;
  let container = document.querySelector(
    ".s-post-container, .p-post-container"
  );
  let qrImg = document.getElementById("qrcode-img");
  document.getElementById("qrcode").addEventListener("click", function() {
    if (select) {
      qrImg.innerHTML = "";
      new QRCode(document.getElementById("qrcode-img"), {
        text:
          url +
          "?index=" +
          (window.scrollY - container.offsetTop) / container.clientHeight,
        width: 180,
        height: 180,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.L
      });
      qrImg.style.visibility = "visible";
      qrImg.style.opacity = "1";
      select = false;
    } else {
      qrImg.style.opacity = "0";
      setTimeout(function() {
        qrImg.style.visibility = "hidden";
      }, 500);
      select = true;
    }
  });
};

origami.tocToggle = function() {
  let select = true;
  if (window.innerWidth > 991) {
    let toc = document.getElementsByClassName("toc")[0];
    document
      .getElementById("toc-button")
      .addEventListener("click", function(e) {
        if (e.target.className == "fa fa-indent fa-2x") {
          if (select) {
            toc.classList.add("toc-show");
            toc.style.boxShadow = "none";
            select = false;
          } else {
            toc.classList.remove("toc-show");
            toc.style.boxShadow = "0 0 20px #B6DFE9";
            select = true;
          }
        }
      });
  }
};

origami.setPosition = function() {
  let index = $getQuery("index");
  let container = document.querySelector(
    ".s-post-container, .p-post-container"
  );
  if (index) {
    index = container.offsetTop + container.clientHeight * index;
    window.scrollTo({
      top: index,
      behavior: "smooth"
    });
    let ifToStart = document.getElementById("if-to-start");
    ifToStart.style.visibility = "visible";
    ifToStart.style.opacity = "1";
  }
};
window.toStart = function() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
  notToStart();
};
window.notToStart = function() {
  let ifToStart = document.getElementById("if-to-start");
  ifToStart.style.opacity = "0";
  setTimeout(function() {
    ifToStart.style.visibility = "visible";
  }, 500);
};

// origami.code_window = function() {
//   $(".toolbar").append(
//     '<div class="toolbar-item"><span class="code-window">全屏</span></div>'
//   );
//   $(".code-window").click(function() {
//     var code_window = window.open();
//     var code = $(this)
//       .parent()
//       .parent()
//       .parent()
//       .html();
//     code_window.document.write("<html><head>");
//     code_window.document.write(
//       '<link rel="stylesheet" id="prism-style-css" href="' +
//         location.protocol +
//         "//" +
//         location.host +
//         '/wp-content/themes/Origami/css/prism.css" type="text/css" media="all"><script type="text/javascript" src="' +
//         location.protocol +
//         "//" +
//         location.host +
//         '/wp-content/themes/Origami/js/prism.js"></script>'
//     );
//     code_window.document.write(
//       "<style>body{margin:0px;background: #272822;}</style></head><body>"
//     );
//     code_window.document.write(
//       '<div id="test" style="background:#272822;width:100%;height:100%;"><div class="code-toolbar">' +
//         code +
//         "</div></div>"
//     );
//     code_window.document.write("</body></html>");
//   });
// };

window.addEventListener("load", function() {
  origami.comments = origami.initComments();
  origami.titleChange();
  origami.scrollTop();
  origami.scrollChange();
  origami.mobileBtn();
  origami.searchBtn();
  origami.realTimeSearch();
  origami.tools.initToast();
  origami.loadOwO();
  origami.buildFooterTime();
  if (
    document.body.classList.contains("page") ||
    document.body.classList.contains("post")
  ) {
    origami.initTocbot();
    origami.readingTransfer();
    origami.tocToggle();
    origami.setPosition();
  }
  new LazyLoad({
    elements_selector: ".lazy",
    load_delay: 500,
    callback_loaded: function(ele) {
      // fix background-image loaded
      if (ele.classList.contains("lazy-bg-loaded-flag")) {
        ele.parentElement.classList.add("loaded");
      }
    }
  });
});

console.log(
  "\n %c Origami 折纸主题 %c https://blog.ixk.me/theme-origami.html \n",
  "color: #fff; background: #4285f4; padding:5px 0;",
  "background: #87d1df; padding:5px 0;"
);
