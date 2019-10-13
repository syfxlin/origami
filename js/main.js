window.$httpGetParams = function(data) {
  var arr = [];
  for (var param in data) {
    arr.push(encodeURIComponent(param) + '=' + encodeURIComponent(data[param]));
  }
  return arr.join('&');
};

window.$http = function(options) {
  options = options || {};
  options.type = (options.type || 'GET').toUpperCase();
  options.dataType = options.dataType || 'json';
  if (options.async === undefined) {
    options.async = true;
  }
  var params = window.$httpGetParams(options.data);
  var xhr;
  if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest();
  } else {
    xhr = new ActiveXObject('Microsoft.XMLHTTP');
  }
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      var status = xhr.status;
      if (status >= 200 && status < 300) {
        if (options.dataType === 'json') {
          options.success && options.success(JSON.parse(xhr.responseText));
        } else {
          options.success && options.success(xhr.responseText);
        }
      } else {
        options.error && options.error(status);
      }
    }
  };
  if (options.type == 'GET') {
    xhr.open('GET', options.url + '?' + params, options.async);
    xhr.send(null);
  } else if (options.type == 'POST') {
    xhr.open('POST', options.url, options.async);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
  } else {
    xhr.open(options.type, options.url, options.async);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
  }
};

window.$getCookie = function(name) {
  var arr,
    reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
  if ((arr = document.cookie.match(reg))) return unescape(arr[2]);
  else return null;
};
window.$clearCookie = function(name) {
  $setCookie(name, '', -1);
};
window.$setCookie = function(name, value, seconds) {
  seconds = seconds || 0;
  var expires = '';
  if (seconds != 0) {
    var date = new Date();
    date.setTime(date.getTime() + seconds * 1000);
    expires = '; expires=' + date.toGMTString();
  }
  document.cookie = name + '=' + escape(value) + expires + '; path=/';
};

window.$getQuery = function(name) {
  var query = window.location.search.substring(1);
  var vars = query.split('&');
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split('=');
    if (pair[0] == name) {
      return pair[1];
    }
  }
  return false;
};

window.$getPath = function(index) {
  let pathName = window.location.pathname.substring(1);
  let pathArray = pathName.split('/');
  return pathArray[index];
};

window.$getPathM = function(reg) {
  let pathName = window.location.pathname;
  if (reg.test(pathName)) {
    return pathName.match(reg)[1];
  } else {
    return false;
  }
};

var origami = {};

origami.titleChange = function() {
  if (origamiConfig.titleChange) {
    var origin = document.title;
    var titleTime;
    document.addEventListener('visibilitychange', function() {
      if (document.hidden) {
        document.title = '(つェ⊂)我藏好了哦~ ' + origin;
        clearTimeout(titleTime);
      } else {
        document.title = '(*´∇｀*) 被你发现啦~ ' + origin;
        titleTime = setTimeout(function() {
          document.title = origin;
        }, 2000);
      }
    });
  }
};

origami.scrollTop = function() {
  let scrollE = function() {
    let el = document.getElementById('scroll-top');
    if (window.scrollY > 50) {
      el.style.opacity = '1';
    } else {
      el.style.opacity = '0';
    }
  };
  scrollE();
  window.addEventListener('scroll', scrollE);
  document.getElementById('scroll-top').addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
};

origami.scrollChange = function() {
  if (!document.body.classList.contains('home')) return;
  let title = document.getElementById('ori-title');
  let logo = document.getElementById('ori-logo');
  let header = document.querySelector('.ori-header');
  if (!document.body.classList.contains('layout1')) {
    let scrollE = function() {
      if (window.scrollY >= 10) {
        header.classList.add('active');
        title.style.display = 'none';
        logo.style.display = 'flex';
      } else {
        header.classList.remove('active');
        title.style.display = 'block';
        logo.style.display = 'none';
      }
    };
    scrollE();
    window.addEventListener('scroll', scrollE);
  } else {
    let target =
      document.getElementsByClassName('carousel')[0].clientHeight -
      document.getElementsByClassName('ori-header')[0].clientHeight;
    let scrollE = function() {
      if (window.scrollY >= target) {
        document.body.classList.add('not-car');
        title.style.display = 'none';
        logo.style.display = 'flex';
      } else {
        document.body.classList.remove('not-car');
        title.style.display = 'block';
        logo.style.display = 'none';
      }
    };
    scrollE();
    window.addEventListener('scroll', scrollE);
  }
};

origami.mobileMenu = function() {
  document.getElementById('ori-h-m-btn').addEventListener('click', function() {
    let btn = document.getElementById('ori-h-m-btn');
    let menu = document.getElementById('ori-h-menu');
    if (btn.classList.contains('active')) {
      btn.classList.remove('active');
      menu.classList.remove('active');
      document.body.classList.remove('menu-active');
    } else {
      btn.classList.add('active');
      menu.classList.add('active');
      document.body.classList.add('menu-active');
    }
  });
  document
    .querySelectorAll('.menu-item-has-children > a > .sub-drop-icon')
    .forEach(function(item) {
      item.addEventListener('click', function(e) {
        let menu = item.parentElement.parentElement.classList;
        if (menu.contains('active')) {
          menu.remove('active');
        } else {
          menu.add('active');
        }
        e.stopPropagation();
        e.preventDefault();
      });
    });
};

origami.searchBtn = function() {
  document.getElementById('ori-h-search').addEventListener('click', function() {
    let el = document.getElementsByClassName('ori-search')[0];
    el.style.display = 'block';
    document.getElementById('ori-search-input').focus();
    el.style.transition = 'opacity 0.5s';
    el.style.opacity = '1';
  });
  document
    .getElementById('ori-h-search-close')
    .addEventListener('click', function() {
      let el = document.getElementsByClassName('ori-search')[0];
      setTimeout(function() {
        el.style.display = 'none';
      }, 500);
      el.style.transition = 'opacity 0.5s';
      el.style.opacity = '0';
    });
};

origami.realTimeSearch = function() {
  let ele = document.getElementById('ori-search-input');
  if (origamiConfig.realTimeSearch) {
    let page = 1;
    let listEle = document.getElementById('search-list');
    let loadingEle = document.querySelector('.ori-search-loading');
    let timer = null;
    let changeSearchList = function(list) {
      listEle.innerHTML = '';
      list.forEach(function(item) {
        let str = '';
        str += '<article class="card" id="post-' + item.id + '">';
        str += '<div class="card-header post-info">';
        str += '<h2 class="card-title">';
        str += '<a href="' + item.link + '">' + item.title.rendered + '</a>';
        str += '</h2>';
        let d = new Date(item.date);
        let dStr =
          d.getFullYear() + '年' + d.getMonth() + '月' + d.getDate() + '日';
        str +=
          '<div class="card-subtitle text-gray"><time>' +
          dStr +
          '</time></div>';
        str += '</div>';
        str += '<div class="card-body">' + item.excerpt.rendered + '</div>';
        str += '<div class="card-footer"><div class="post-tags"></div>';
        str += '<a class="read-more" href="' + item.link + '">阅读更多</a>';
        str += '</div>';
        listEle.innerHTML += str;
      });
    };

    ele.addEventListener('input', function() {
      clearTimeout(timer);
      timer = setTimeout(function() {
        if (ele.value == '') {
          listEle.innerHTML = '';
          return;
        }
        loadingEle.style.visibility = 'visible';
        loadingEle.style.opacity = '1';
        $http({
          url: '/wp-json/wp/v2/posts',
          type: 'GET',
          dataType: 'json',
          data: {
            search: ele.value,
            page: page
          },
          success: function(response) {
            loadingEle.style.opacity = '0';
            setTimeout(function() {
              loadingEle.style.visibility = 'hidden';
            }, 500);
            changeSearchList(response);
          },
          error: function(status) {
            console.log('状态码为' + status);
          }
        });
      }, 300);
    });
  } else {
    ele.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        window.location.href = window.location.origin + '/?s=' + ele.value;
      }
    });
  }
};

origami.tools = {
  toastList: [],
  showToast: function(massage, status) {
    let className = 'toast-' + status;
    let toast = document.querySelector('.ori-tools .toast');
    toast.classList.add(className);
    toast.querySelector('p').innerHTML = massage;
    toast.style.visibility = 'visible';
    toast.style.opacity = '1';
  },
  hideToast: function(callback = () => {}) {
    let toast = document.querySelector('.ori-tools .toast');
    toast.style.opacity = '0';
    setTimeout(function() {
      toast.style.visibility = 'hidden';
      toast.className = 'toast';
      toast.querySelector('p').innerHTML = '';
      callback();
    }, 500);
  },
  popToast: function() {
    let toast = origami.tools.toastList[0];
    origami.tools.showToast(toast.massage, toast.status);
    setTimeout(function() {
      origami.tools.hideToast(function() {
        origami.tools.toastList.shift();
        if (origami.tools.toastList.length !== 0) {
          origami.tools.popToast();
        }
      });
    }, toast.delay);
  },
  timeToast: function(massage, status, delay) {
    origami.tools.toastList.push({
      massage: massage,
      status: status,
      delay: delay
    });
    if (origami.tools.toastList.length === 1) {
      origami.tools.popToast();
    }
  },
  initToast: function() {
    document
      .querySelector('.ori-tools .toast .btn-clear')
      .addEventListener('click', function() {
        origami.tools.hideToast();
      });
  },
  showModal: function(title, content, confirm = () => {}, cancel = () => {}) {
    let modal = document.querySelector('.ori-tools .modal');
    modal.querySelector('.modal-title').textContent = title;
    modal.querySelector('.modal-body .content').textContent = content;
    let confirmEle = modal.querySelector('.confirm');
    let confirmFun = function(e) {
      confirm(e);
      origami.tools.hideModal();
      confirmEle.removeEventListener('click', confirmFun);
    };
    confirmEle.addEventListener('click', confirmFun);
    let cancelEle = modal.querySelector('.cancel');
    let cancelFun = function(e) {
      cancel(e);
      origami.tools.hideModal();
      cancelEle.removeEventListener('click', cancelFun);
    };
    cancelEle.addEventListener('click', cancelFun);
    modal.classList.add('active');
    modal.style.visibility = 'visible';
  },
  hideModal: function() {
    let modal = document.querySelector('.ori-tools .modal');
    modal.style.visibility = 'hidden';
    modal.classList.remove('active');
  }
};

origami.initComments = function() {
  let listEle = document.getElementById('comments-list');
  if (!listEle) return;
  let nav = document.getElementsByClassName('comments-nav')[0];
  let select = document.getElementById('comments-select');
  let nextBtn = document.getElementById('comments-next');
  let prevBtn = document.getElementById('comments-prev');
  let isOne = true;
  let postId = listEle.getAttribute('data-postid');
  let pageCount = listEle.getAttribute('data-pagecount');
  let pageOut = 1;

  let commentToHtml = function(item, lv = 1, option = {}) {
    let str = '';
    str +=
      '<div id="comment-' +
      item.comment_ID +
      '" class="comment-lv' +
      lv +
      ' comment-item">';
    str += item.comment_avatar;
    str += '<div class="comment-content"><div class="comment-header">';
    if (item.comment_author_url == '') {
      str += '<div class="comment-author">' + item.comment_author + '</div>';
    } else {
      str +=
        '<div class="comment-author"><a href="' +
        item.comment_author_url +
        '">' +
        item.comment_author +
        '</a></div>';
    }
    str += item.comment_mark;
    if (option.enCountdown) {
      str += '<div class="countdown">可操作剩余时间：<span></span></div>';
    }
    if (item.comment_approved != '1') {
      str += '<div class="not-approved">您的评论还在等待审核</div>';
    }
    str += '</div>';
    str += '<div class="comment-body">' + item.comment_content + '</div>';
    str += '<div class="comment-footer">';
    str +=
      '<div class="comment-date"><i class="fa fa-clock-o" aria-hidden="true"></i>';
    str += '发表于: <time>' + item.comment_date + '</time></div>';
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
      str += '</span>';
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
      str += '</span>';
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
    str += '</span>';
    str += '</div></div></div></div>';
    return str;
  };
  let commentsToList = function(list, lv = 1) {
    let str = '';
    list.forEach(function(item) {
      str += commentToHtml(item, lv);
      if (item.sub != []) {
        str +=
          '<ul class="comment-children">' +
          commentsToList(item.sub, lv + 1) +
          '</ul>';
      }
    });
    return str;
  };
  let changeNav = function() {
    if (pageOut == 1) {
      prevBtn.style.display = 'none';
    } else {
      prevBtn.style.display = 'block';
    }
    if (pageOut == pageCount) {
      nextBtn.style.display = 'none';
    } else {
      nextBtn.style.display = 'block';
    }
    select.value = pageOut;
  };
  let load = function(page = -1, callback = () => {}) {
    if (page == -1) {
      page = pageOut;
    }
    let loading = document.getElementById('comments-loading');
    if (!isOne) {
      window.scrollTo({
        top: loading.offsetTop - 200,
        behavior: 'smooth'
      });
    }
    loading.style.height = '4rem';
    listEle.style.height = '0px';
    if (page <= 0) {
      page = 1;
    }
    if (page > pageCount) {
      page = pageCount;
    }
    let loadF = function() {
      $http({
        url: '/wp-json/origami/v1/comments',
        type: 'GET',
        dataType: 'json',
        data: {
          id: postId,
          page: page
        },
        success: function(response) {
          loading.style.height = '0';
          listEle.innerHTML = commentsToList(response);
          listEle.style.height = listEle.scrollHeight + 'px';
          setTimeout(function() {
            listEle.style.height = 'unset';
          }, 600);
          pageOut = page;
          changeNav();
          callback(pageOut, response);
        },
        error: function(status) {
          console.log('状态码为' + status);
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
        url: '/wp-json/origami/v1/comments',
        type: 'POST',
        dataType: 'json',
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
          console.log('状态码为' + status);
        }
      });
    } else {
      $http({
        url: '/wp-json/origami/v1/comments',
        type: 'PUT',
        dataType: 'json',
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
          console.log('状态码为' + status);
        }
      });
    }
  };
  let submitError = function(res) {
    origami.tools.timeToast(res.massage, 'error', 5000);
  };
  let submitSuccess = function(res, lv = 1) {
    // 显示和定时隐藏提示
    origami.tools.timeToast('评论成功ヾ(≧▽≦*)o', 'success', 3000);
    // 清空评论框中的值
    document.getElementById('response-text').value = '';
    // 构造新的comment节点
    let newComment = new DOMParser()
      .parseFromString(
        commentToHtml(res, lv, {
          enDelete: origamiConfig.deleteComment,
          enUpdate: origamiConfig.updateComment,
          enCountdown: true
        }),
        'text/html'
      )
      .getElementsByClassName('comment-item')[0];
    let time = $getCookie('change_comment_time');
    let countdown = setInterval(function() {
      let last = parseInt(time) - Math.round(Date.now() / 1000);
      if (last == 0) {
        clearInterval(countdown);
        newComment.querySelector('.comment-update-link').parentElement.remove();
        newComment.querySelector('.comment-delete-link').parentElement.remove();
        newComment.querySelector('.countdown').remove();
      }
      newComment.querySelector('.countdown span').textContent = last;
    }, 1000);
    let responseForm = document.getElementById('comments-form');
    let respondMain = document.getElementById('comments-response');
    let parent = responseForm.parentElement;
    if (parent.id == 'comments-response') {
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
      nav.style.display = 'flex';
    }
    let str = '';
    for (let i = 1; i <= pageCount; i++) {
      str += '<option value="' + i + '">第' + i + '页</option>';
    }
    select.innerHTML = str;
    select.addEventListener('change', function() {
      load(select.value);
    });
    nextBtn.addEventListener('click', loadNext);
    prevBtn.addEventListener('click', loadPrev);
  };
  let initSubmit = function() {
    new SMValidator('form');
    let submitEle = document.getElementById('response-submit');
    submitEle.addEventListener('click', function(e) {
      let loadingEle = document.getElementsByClassName('response-loading')[0];
      let authorNameEle = document.getElementById('response-author');
      let authorEmailEle = document.getElementById('response-email');
      let contentEle = document.getElementById('response-text');
      if (
        contentEle.style.color ||
        authorEmailEle.style.color ||
        authorNameEle.style.color
      ) {
        console.log('输入有误');
        return;
      }
      let content = contentEle.value;
      if (origamiConfig.markdownComment) {
        content = marked(content);
      }
      let info = {
        post: submitEle.getAttribute('data-postid'),
        parent: submitEle.getAttribute('data-commentid'),
        content: content,
        author_email: authorEmailEle.value,
        author_name: authorNameEle.value,
        author_url: document.getElementById('response-website').value
      };
      loadingEle.style.opacity = '1';
      submit(
        info,
        function(res) {
          loadingEle.style.opacity = '0';
          if (res.code) {
            submitError(res);
            return;
          }
          submitSuccess(res, submitEle.getAttribute('data-lv'));
        },
        submitEle.getAttribute('data-isupdate') == 'true'
      );
      e.preventDefault();
    });
  };
  let initReply = function() {
    let response = document.getElementById('comments-response');
    let form = document.getElementById('comments-form');
    let submitEle = document.getElementById('response-submit');
    let closeResponse = document.getElementById('close-response');
    closeResponse.addEventListener('click', function() {
      form.remove();
      response.appendChild(form);
      submitEle.setAttribute('data-commentid', 0);
      submitEle.setAttribute('data-lv', 1);
      closeResponse.style.visibility = 'hidden';
    });
    document.querySelectorAll('.comment-reply-link').forEach(function(item) {
      item.addEventListener('click', function() {
        let parentId = item.getAttribute('data-commentid');
        form.remove();
        document
          .querySelector('#comment-' + parentId)
          .nextElementSibling.appendChild(form);
        submitEle.setAttribute('data-commentid', parentId);
        submitEle.setAttribute(
          'data-lv',
          parseInt(item.getAttribute('data-lv')) + 1
        );
        closeResponse.style.visibility = 'visible';
      });
    });
  };
  let initBtn = function() {
    let deleteBtn = document.getElementsByClassName('comment-delete-link')[0];
    deleteBtn.addEventListener('click', function() {
      origami.tools.showModal('删除评论', '确定要删除这条评论？', function() {
        $http({
          url: '/wp-json/origami/v1/comments',
          type: 'DELETE',
          dataType: 'json',
          data: {
            id: deleteBtn.getAttribute('data-commentid')
          },
          success: function(res) {
            if (res || res == 'true') {
              document
                .getElementById(
                  'comment-' + deleteBtn.getAttribute('data-commentid')
                )
                .remove();
              origami.tools.timeToast('删除评论成功！', 'success', 3000);
            }
          }
        });
      });
    });

    let updateBtn = document.getElementsByClassName('comment-update-link')[0];
    updateBtn.addEventListener('click', function() {
      let form = document.getElementById('comments-form');
      let submitEle = document.getElementById('response-submit');
      let closeResponse = document.getElementById('close-response');
      let commentId = updateBtn.getAttribute('data-commentid');
      let commentEle = document.getElementById('comment-' + commentId);
      submitEle.setAttribute('data-commentid', commentId);
      submitEle.setAttribute(
        'data-lv',
        parseInt(updateBtn.getAttribute('data-lv'))
      );
      submitEle.setAttribute('data-isupdate', 'true');
      let parent = commentEle.parentElement;
      let next = commentEle.nextElementSibling;
      form.remove();
      parent.replaceChild(form, commentEle);
      document.getElementById('response-text').value = commentEle.querySelector(
        '.comment-body'
      ).innerHTML;
      closeResponse.style.visibility = 'visible';
      let repl = function() {
        parent.insertBefore(commentEle, next);
        document.getElementById('response-text').value = '';
        submitEle.removeAttribute('data-isupdate');
        closeResponse.removeEventListener('click', repl);
      };
      closeResponse.addEventListener('click', repl);
    });
  };
  let init = function() {
    let commentPage = $getQuery('comment_page');
    let commentPageP = $getPathM(/comment-page-(\d+)/i);
    if (commentPage) {
      pageOut = commentPage;
    } else if (commentPageP) {
      pageOut = parseInt(pageCount) + 1 - commentPageP;
    }
    initNav();
    load(-1, function() {
      if (window.location.hash != '') {
        setTimeout(function() {
          window.scrollTo({
            top: document.querySelector(window.location.hash).offsetTop - 200
          });
          document
            .querySelector(window.location.hash)
            .classList.add('changeshadow');
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
  if (origamiConfig.owo && document.querySelector('.OwO')) {
    new OwO({
      logo: 'OωO表情',
      container: document.getElementsByClassName('OwO')[0],
      target: document.getElementById('response-text'),
      api: location.origin + '/wp-content/themes/Origami/js/OwO.json',
      position: 'down',
      width: '100%',
      maxHeight: '250px'
    });
  }
};

origami.buildFooterTime = function() {
  if (!origamiConfig.footerTime) return;
  var now = new Date();
  let dateEle = document.getElementById('timeDate');
  let timeEle = document.getElementById('times');
  if (!dateEle && !timeEle) return;
  function createtime() {
    var grt = new Date(origamiConfig.footerTime);
    now.setTime(now.getTime() + 250);
    days = (now - grt) / 1000 / 60 / 60 / 24;
    dnum = Math.floor(days);
    hours = (now - grt) / 1000 / 60 / 60 - 24 * dnum;
    hnum = Math.floor(hours);
    if (String(hnum).length == 1) {
      hnum = '0' + hnum;
    }
    minutes = (now - grt) / 1000 / 60 - 24 * 60 * dnum - 60 * hnum;
    mnum = Math.floor(minutes);
    if (String(mnum).length == 1) {
      mnum = '0' + mnum;
    }
    seconds =
      (now - grt) / 1000 - 24 * 60 * 60 * dnum - 60 * 60 * hnum - 60 * mnum;
    snum = Math.round(seconds);
    if (String(snum).length == 1) {
      snum = '0' + snum;
    }
    if (dateEle) {
      dateEle.innerHTML = '' + dnum + '天';
    }
    if (timeEle) {
      timeEle.innerHTML = hnum + '小时' + mnum + '分' + snum + '秒';
    }
  }
  setInterval(createtime, 250);
};

origami.initTocbot = function() {
  let tocLevel = origamiConfig.tocLevel ? origamiConfig.tocLevel : 'h1, h2, h3';
  let content = document.querySelector('.s-post-content,.p-post-content');
  let i = 0;
  if (!content || !content.querySelectorAll(tocLevel)) return;
  content.querySelectorAll(tocLevel).forEach(function(item) {
    item.id = 'title-' + i;
    i++;
  });
  let offset = document.querySelector('.ori-header').clientHeight;
  tocbot.init({
    tocSelector: '.toc',
    contentSelector: '.s-post-content,.p-post-content',
    headingSelector: tocLevel,
    headingsOffset: offset + 21,
    onClick: function(e) {
      window.scrollTo({
        top: document.querySelector(e.target.hash).offsetTop - offset - 20,
        behavior: 'smooth'
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
    '.s-post-container, .p-post-container'
  );
  let qrImg = document.getElementById('qrcode-img');
  document.getElementById('qrcode').addEventListener('click', function() {
    if (select) {
      qrImg.innerHTML = '';
      new QRCode(document.getElementById('qrcode-img'), {
        text:
          url +
          '?index=' +
          (window.scrollY - container.offsetTop) / container.clientHeight,
        width: 180,
        height: 180,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.L
      });
      qrImg.style.visibility = 'visible';
      qrImg.style.opacity = '1';
      select = false;
    } else {
      qrImg.style.opacity = '0';
      setTimeout(function() {
        qrImg.style.visibility = 'hidden';
      }, 500);
      select = true;
    }
  });
};

origami.tocToggle = function() {
  let select = true;
  if (window.innerWidth > 991) {
    let toc = document.getElementsByClassName('toc')[0];
    document
      .getElementById('toc-button')
      .addEventListener('click', function(e) {
        if (e.target.className == 'fa fa-indent fa-2x') {
          if (select) {
            toc.classList.add('toc-show');
            toc.style.boxShadow = 'none';
            select = false;
          } else {
            toc.classList.remove('toc-show');
            toc.style.boxShadow = '0 0 20px #B6DFE9';
            select = true;
          }
        }
      });
  }
};

origami.setPosition = function() {
  let index = $getQuery('index');
  let container = document.querySelector(
    '.s-post-container, .p-post-container'
  );
  if (index) {
    index = container.offsetTop + container.clientHeight * index;
    window.scrollTo({
      top: index,
      behavior: 'smooth'
    });
    let ifToStart = document.getElementById('if-to-start');
    ifToStart.style.visibility = 'visible';
    ifToStart.style.opacity = '1';
  }
};
window.toStart = function() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
  let url = window.location.href;
  let index = 'index=' + $getQuery('index');
  url = url
    .replace(index + '&', '')
    .replace('&' + index, '')
    .replace('?' + index, '')
    .replace(index, '');
  window.history.pushState(null, document.title, url);
  notToStart();
};
window.notToStart = function() {
  let ifToStart = document.getElementById('if-to-start');
  ifToStart.style.opacity = '0';
  setTimeout(function() {
    ifToStart.style.visibility = 'visible';
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

origami.codeFullScreen = function() {
  document.querySelectorAll('.code-toolbar .toolbar').forEach(function(item) {
    let toolbarItem = document.createElement('div');
    toolbarItem.className = 'toolbar-item';
    let codeFullBtn = document.createElement('a');
    codeFullBtn.className = 'code-fullscreen';
    codeFullBtn.textContent = '全屏';
    toolbarItem.append(codeFullBtn);
    item.append(toolbarItem);
    let full = false;
    codeFullBtn.addEventListener('click', function() {
      if (!full) {
        item.parentElement.classList.add('fullscreen');
        codeFullBtn.textContent = '退出全屏';
      } else {
        item.parentElement.classList.remove('fullscreen');
        codeFullBtn.textContent = '全屏';
      }
      full = !full;
    });
  });
};

origami.animate = function() {
  if (origamiConfig.animate) {
    document
      .querySelectorAll(
        '.home .post-list article, .home .post-pagination, .home .about-card, .home .sidebar-widget'
      )
      .forEach(function(item) {
        if (window.pageYOffset + window.innerHeight > item.offsetTop) {
          item.classList.add('fadeInUp');
        } else {
          let scroll = function() {
            if (window.pageYOffset + window.innerHeight > item.offsetTop) {
              item.classList.add('fadeInUp');
              window.removeEventListener('scroll', scroll);
            }
          };
          window.addEventListener('scroll', scroll);
        }
      });
  }
};

origami.initMarkdown = function() {
  if (origamiConfig.katex) {
    try {
      renderMathInElement(
        document.querySelector('.s-post-content, .p-post-content'),
        {
          delimiters: [
            { left: '$$', right: '$$' },
            { left: '```math', right: '```' },
            { left: '```tex', right: '```' }
          ],
          ignoredTags: ['script', 'noscript', 'style', 'textarea', 'code']
        }
      );
    } catch (e) {
      console.log(e);
    }
  }
  if (origamiConfig.mermaid) {
    try {
      mermaid.init({ noteMargin: 10 }, '.xkeditor-mermaid');
    } catch (error) {
      console.log('May have errors');
    }
  }
};

origami.imgBox = function() {
  new Zooming({
    bgColor: 'rgba(0,0,0,0.5)',
    custemSize: '90%',
    zIndex: 9999,
    onOpen: function() {
      origami.tools.timeToast('按住图片可放大', 'success', 3000);
    }
  }).listen('.s-post-content img, .p-post-content img');
};

origami.readProgress = function() {
  let progress = document.getElementById('read-progress');
  progress.style.width =
    (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100 +
    '%';
  window.addEventListener('scroll', function() {
    progress.style.width =
      (window.scrollY / (document.body.scrollHeight - window.innerHeight)) *
        100 +
      '%';
  });
};

origami.liveChat = function() {
  if (!origamiConfig.liveChat) {
    return;
  } else {
    document.getElementById('live-chat').style.display = 'block';
  }
  let chatWs = null;
  let conn = function(
    name,
    callOpen = () => {},
    callMsg = () => {},
    callClose = () => {}
  ) {
    let url = origamiConfig.liveChat + '?name=' + name;
    chatWs = new WebSocket(url);
    chatWs.onerror = function() {
      origami.tools.timeToast('连接Server失败!', 'error', 3000);
    };
    chatWs.onopen = function(evt) {
      console.log('Connection open ...');
      callOpen(evt);
    };
    chatWs.onmessage = function(evt) {
      console.log('Received Message');
      callMsg(evt);
    };
    chatWs.onclose = function(evt) {
      console.log('Connection closed.');
      callClose(evt);
    };
  };
  let bgColor = [
    'rgba(0, 0, 0, 0.8)',
    '#3280fc',
    '#03b8cf',
    '#ea644a',
    '#38b03f',
    '#f1a325',
    '#bd7b46',
    '#8666b8'
  ];
  let msgEle = document.getElementById('live-chat');
  let list = msgEle.querySelector('.live-chat-list');
  let showChat = function() {
    list.style.visibility = 'visible';
    list.style.opacity = '1';
  };
  let hideChat = function() {
    list.style.opacity = '0';
    setTimeout(function() {
      list.style.visibility = 'hidden';
    }, 500);
  };
  let inputEle = document.querySelector('.live-chat-input');
  let inputI = inputEle.querySelector('i');
  let inputBtn = inputEle.querySelector('button');
  let inputInput = inputEle.querySelector('input');
  let showInput = false;
  let isInputName = false;
  let commentName = null;
  inputI.addEventListener('click', function() {
    if (!showInput) {
      inputEle.classList.add('active');
      inputI.classList.replace('icon-arrow-left', 'icon-arrow-right');
      showChat();
    } else {
      inputEle.classList.remove('active');
      inputI.classList.replace('icon-arrow-right', 'icon-arrow-left');
      hideChat();
    }
    showInput = !showInput;
  });
  let enter = function() {
    if (!isInputName) {
      commentName = inputInput.value;
      conn(
        commentName,
        function() {
          inputBtn.textContent = '发送';
          inputInput.placeholder = '来一发女装宣言！';
          inputInput.value = '';
        },
        function(e) {
          let data = JSON.parse(e.data);
          if (data.type == 'message') {
            addMsg(data.name, data.message);
          } else if (data.type == 'openSuccess') {
            let count = data.all.length;
            origami.tools.timeToast(
              '目前共有：' + count + '位用户在线。',
              'success',
              3000
            );
            data.all.forEach(function(item) {
              if (item.message !== '') {
                addMsg(item.name, item.message);
              }
            });
          } else if (data.type == 'join') {
            origami.tools.timeToast(data.message, 'success', 3000);
          } else if (data.type == 'close') {
            origami.tools.timeToast(data.message, 'warning', 3000);
          } else {
            console.log(data);
          }
        },
        function() {
          inputBtn.textContent = '开始搞事';
          inputInput.placeholder = '输入昵称与大佬们交流';
          inputInput.value = '';
        }
      );
      isInputName = true;
    } else {
      let data = {
        name: commentName,
        message: inputInput.value
      };
      chatWs.send(JSON.stringify(data));
      inputInput.value = '';
      addMsg(data.name, data.message);
    }
  };
  inputInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      enter();
    }
  });
  inputBtn.addEventListener('click', enter);
  let addMsg = function(nameStr, contentStr) {
    let item = document.createElement('li');
    let name = document.createElement('div');
    let content = document.createElement('div');
    name.textContent = nameStr;
    name.className = 'live-chat-name';
    content.textContent = contentStr;
    content.className = 'live-chat-content';
    item.append(name);
    item.append(content);
    item.style.background = bgColor[Math.floor(Math.random() * 8)];
    item.classList.add('fadeInUp100');
    if (list.querySelectorAll('li').length > 4) {
      list.firstElementChild.classList.add('fadeOutUp100');
      setTimeout(function() {
        list.firstElementChild.remove();
      }, 1000);
    }
    setTimeout(function() {
      item.classList.add('fadeOutUp100');
      setTimeout(function() {
        item.remove();
      }, 1000);
    }, 10000);
    list.append(item);
  };
};

origami.background = function(data = 'init') {
  if (!origamiConfig.background) return;
  let themeIndex;
  if (data === 'init') {
    themeIndex = $getCookie('theme');
    if (!themeIndex) {
      themeIndex = 0;
    }
  } else {
    themeIndex = data;
  }
  let images = origamiConfig.background[themeIndex].background;
  let bgEle = document.querySelector('.ori-background');
  bgEle.innerHTML = '';
  images.forEach(function(item, index) {
    let itemEle = document.createElement('div');
    itemEle.style.backgroundImage = 'url(' + item + ')';
    itemEle.setAttribute('data-index', index);
    bgEle.append(itemEle);
  });
  let index = 0;
  let oldEle = bgEle.querySelector('[data-index="' + index + '"]');
  setInterval(function() {
    oldEle.style.opacity = '0';
    index++;
    if (index >= images.length) {
      index = 0;
    }
    oldEle = bgEle.querySelector('[data-index="' + index + '"]');
    oldEle.style.opacity = '1';
  }, 10000);
};

origami.layoutImageChange = function() {
  if (!document.body.classList.contains('home')) return;
  if (document.body.classList.contains('layout3')) {
    let bgEle = document.querySelector('.layout3-images');
    let index = 1;
    let oldEle = bgEle.querySelector('[data-index="' + index + '"]');
    setInterval(function() {
      oldEle.style.opacity = '0';
      index++;
      if (index >= 5) {
        index = 1;
      }
      oldEle = bgEle.querySelector('[data-index="' + index + '"]');
      oldEle.style.opacity = '1';
    }, 10000);
  }
};

origami.paperPlane = function() {
  let index = 0;
  let mask = document.querySelector('.paper-plane-mask');
  let body = document.querySelector('.paper-plane-body');
  let setTheme = function(i) {
    $setCookie('theme', i, 86400);
    origami.background(i);
    mask.style.transform = 'scale(0)';
    setTimeout(function() {
      mask.style.visibility = 'hidden';
    }, 5000);
    index = 0;
    open = false;
  };
  let add = function(data) {
    if (index - 2 < 0) {
      left.classList.add('disabled');
    } else {
      left.classList.remove('disabled');
    }
    if (index + 2 >= origamiConfig.background.length) {
      right.classList.add('disabled');
    } else {
      right.classList.remove('disabled');
    }
    body.innerHTML = '';
    data.forEach(function(item, i) {
      if (!item) return;
      let li = document.createElement('li');
      li.className = 'col-6 col-md-12';
      li.setAttribute('data-index', index + i);
      let title = document.createElement('div');
      title.className = 'title';
      title.textContent = item.name;
      let content = document.createElement('div');
      content.className = 'content';
      content.style.backgroundImage = 'url(' + item.background[0] + ')';
      li.append(title);
      li.append(content);
      body.append(li);
      li.addEventListener('click', function() {
        setTheme(li.getAttribute('data-index'));
      });
    });
  };
  let open = false;
  let planeEle = document.getElementById('paper-plane');
  planeEle.addEventListener('click', function() {
    if (!open) {
      planeEle.classList.add('flyaway');
      setTimeout(function() {
        planeEle.classList.remove('flyaway');
      }, 1500);
      mask.style.visibility = 'visible';
      mask.style.transform = 'scale(1)';
      open = true;
      add([
        origamiConfig.background[index],
        origamiConfig.background[index + 1]
      ]);
    }
  });
  document
    .querySelector('.paper-plane-content .close')
    .addEventListener('click', function(e) {
      mask.style.transform = 'scale(0)';
      setTimeout(function() {
        mask.style.visibility = 'hidden';
      }, 5000);
      index = 0;
      open = false;
      e.stopPropagation();
    });
  let left = document.querySelector('.paper-plane-content .left');
  let right = document.querySelector('.paper-plane-content .right');
  left.addEventListener('click', function(e) {
    e.stopPropagation();
    if (index - 2 < 0) {
      return;
    }
    index = index - 2;
    add([origamiConfig.background[index], origamiConfig.background[index + 1]]);
  });
  right.addEventListener('click', function(e) {
    e.stopPropagation();
    if (index + 2 >= origamiConfig.background.length) {
      return;
    }
    index = index + 2;
    add([origamiConfig.background[index], origamiConfig.background[index + 1]]);
  });
};

origami.copy = function() {
  let setting = origamiConfig.copyAddCopyright;
  let inner = function(e) {
    if (setting === 'none') return;
    if (setting === 'ncode' && e.target.nodeName === 'CODE') return;
    e.preventDefault();
    let html =
      window.getSelection().toString() +
      '<br><br>本文采用 CC BY-NC-SA 3.0 许可协议，著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。<br>作者：' +
      document.querySelector('.post-info .card-subtitle span').textContent +
      '<br>来源：' +
      document.title +
      '<br>链接：' +
      window.location.href;
    let plain =
      window.getSelection().toString() +
      '\n\n本文采用 CC BY-NC-SA 3.0 许可协议，著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。\n作者：' +
      document.querySelector('.post-info .card-subtitle span').textContent +
      '\n来源：' +
      document.title +
      '\n链接：' +
      window.location.href;
    e.clipboardData.setData('text/html', html);
    e.clipboardData.setData('text/plain', plain);
    if (window.clipboardData) return window.clipboardData.setData('text', html);
  };
  document.body.addEventListener('copy', function(e) {
    if (window.getSelection().toString().length > 10) {
      inner(e);
    }
  });
};

origami.hasNewInspiration = function() {
  if (origamiConfig.lastInspirationTime) {
    let oldTime = window.localStorage.getItem('inspirationTime');
    if (!oldTime || oldTime < origamiConfig.lastInspirationTime) {
      origami.tools.timeToast(
        '有新灵感发布哦，要记得去看哟。ヾ(≧▽≦*)o',
        'success',
        5000
      );
    }
    window.localStorage.setItem(
      'inspirationTime',
      origamiConfig.lastInspirationTime
    );
  }
};

origami.initGitCard = function() {
  let inner = (cardEle, user, repo, content, star, platform) => {
    let head =
      '<a href="' +
      user.url +
      '">' +
      user.name +
      '</a>' +
      '/' +
      '<a href="' +
      repo.url +
      '">' +
      repo.name +
      '</a>';
    let headEle = cardEle.querySelector('.gitcard-head');
    headEle.innerHTML = head;
    headEle.style.visibility = 'visible';
    let body =
      content.description +
      ' <a href="' +
      content.homepage +
      '">' +
      content.homepage +
      '</a>';
    let bodyEle = cardEle.querySelector('.gitcard-body');
    bodyEle.innerHTML = body;
    bodyEle.classList.remove('loading');
    cardEle.querySelector('.gitcard-footer').style.visibility = 'visible';
    cardEle.querySelector('.gitcard-star').innerHTML = '★' + star;
    cardEle.querySelector('.gitcard-to').innerHTML =
      '<a href="' + repo.url + '"><i class="icon icon-arrow-right"></i></a>';
  };
  document.querySelectorAll('.gitcard').forEach(cardEle => {
    let repo = cardEle.getAttribute('data-repo');
    let platform = cardEle.getAttribute('data-platform');
    if (platform === 'github') {
      $http({
        url: 'https://api.github.com/repos/' + repo,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
          inner(
            cardEle,
            {
              url: res.owner.html_url,
              name: res.owner.login
            },
            {
              url: res.html_url,
              name: res.name
            },
            {
              description: res.description,
              homepage: res.homepage
            },
            res.stargazers_count,
            platform
          );
        },
        error: function(status) {
          console.log('状态码为' + status);
        }
      });
    } else if (platform === 'gitlab') {
      $http({
        url: 'https://gitlab.com/api/v4/projects/' + encodeURIComponent(repo),
        type: 'GET',
        dataType: 'json',
        success: function(res) {
          inner(
            cardEle,
            {
              url: res.namespace.web_url,
              name: res.namespace.path
            },
            {
              url: res.web_url,
              name: res.path
            },
            {
              description: res.description,
              homepage: ''
            },
            res.star_count,
            platform
          );
        },
        error: function(status) {
          console.log('状态码为' + status);
        }
      });
    }
  });
};

origami.initArticleCard = function() {
  let inner = (
    cardEle,
    title,
    description,
    url,
    thumbnail,
    author_name,
    provider_name,
    provider_url
  ) => {
    if (thumbnail) {
      cardEle.style.backgroundImage = 'url(' + thumbnail + ')';
    }
    let head = '<a href="' + url + '">' + title + '</a>';
    let headEle = cardEle.querySelector('.articlecard-head');
    headEle.innerHTML = head;
    headEle.style.visibility = 'visible';
    let bodyEle = cardEle.querySelector('.articlecard-body');
    bodyEle.innerHTML = description;
    bodyEle.classList.remove('loading');
    cardEle.querySelector('.articlecard-footer').style.visibility = 'visible';
    cardEle.querySelector('.articlecard-info').innerHTML =
      '<a href="' + provider_url + '">' + provider_name + '</a>';
    cardEle.querySelector('.articlecard-to').innerHTML =
      '<a href="' + url + '"><i class="icon icon-arrow-right"></i></a>';
  };
  document.querySelectorAll('.articlecard').forEach(cardEle => {
    let url = cardEle.getAttribute('data-url');
    let platform = cardEle.getAttribute('data-platform');
    var re = /(\w+):\/\/([^\:|\/]+)(\:\d*)?(.*\/)?([^#|\?|\n]+)?(#.*)?(\?.*)?/i;
    var m = url.match(re);
    if (platform === 'origami') {
      $http({
        url: m[1] + '://' + m[2] + '/wp-json/origami/v1/pembed?url=' + url,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
          inner(
            cardEle,
            res.title,
            res.description,
            res.url,
            res.thumbnail,
            res.author_name,
            res.provider_name,
            res.provider_url
          );
        },
        error: function(status) {
          console.log('状态码为' + status);
        }
      });
    } else if (platform === 'embed') {
      $http({
        url: url + (url.charAt(url.length - 1) === '/' ? 'embed' : '/embed'),
        type: 'GET',
        dataType: 'html',
        success: function(res) {
          let domp = new DOMParser();
          let d = domp.parseFromString(res, 'text/html');
          d.querySelector('.wp-embed-more').remove();
          inner(
            cardEle,
            d.querySelector('.wp-embed-heading a').innerHTML,
            d.querySelector('.wp-embed-excerpt p').innerHTML,
            url,
            null,
            '',
            d.querySelector('.wp-embed-site-title a span').innerHTML,
            d.querySelector('.wp-embed-site-title a').href
          );
        }
      });
    }
  });
};

// Run
var isPost =
  document.body.classList.contains('page') ||
  document.body.classList.contains('single');

origami.animate();
origami.scrollChange();
origami.tools.initToast();
origami.titleChange();
origami.buildFooterTime();
origami.scrollTop();
origami.mobileMenu();
origami.searchBtn();
origami.realTimeSearch();
origami.layoutImageChange();
origami.copy();

if (isPost) {
  origami.readProgress();
}

window.addEventListener('load', function() {
  // document.querySelector(".carousel").classList.add("fadeInDown");
  origami.liveChat();
  origami.background();
  origami.paperPlane();
  origami.hasNewInspiration();
  if (isPost) {
    origami.readingTransfer();
    origami.setPosition();
    origami.codeFullScreen();
    origami.initMarkdown();
    origami.imgBox();
    origami.comments = origami.initComments();
    origami.initTocbot();
    origami.tocToggle();
    origami.loadOwO();
    origami.initGitCard();
    origami.initArticleCard();
  }
  if (LazyLoad) {
    new LazyLoad({
      elements_selector: '.lazy',
      load_delay: 500,
      callback_loaded: function(ele) {
        // fix background-image loaded
        if (ele.classList.contains('lazy-bg-loaded-flag')) {
          ele.parentElement.classList.add('loaded');
        }
      }
    });
  }
});

console.log(
  "\n %c Otstar's Blog %c https://blog.ixk.me/ \n",
  'color: #fff; background: #4285f4; padding:5px 0;',
  'background: #87d1df; padding:5px 0;'
);

console.log(
  '\n %c 🎉 Origami 折纸主题 | Version ' +
    document.querySelector('meta[name="origami-version"]').content +
    ' | Otstar Lin %c https://blog.ixk.me/theme-origami.html \n',
  'color: #fff; background: #4285f4; padding:5px 0;',
  'background: #87d1df; padding:5px 0;'
);

console.log(
  '%c ',
  'background:url(' +
    window.location.origin +
    '/wp-content/themes/Origami/image/comment-1.png) no-repeat center;background-size:200px;padding-left:200px;padding-bottom:162px;overflow:hidden;border-radius:10px;margin:5px 0'
);
