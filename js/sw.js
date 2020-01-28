importScripts(
  'https://cdn.jsdelivr.net/npm/workbox-cdn@3.6.3/workbox/workbox-sw.js'
);
workbox.setConfig({
  modulePathPrefix: 'https://cdn.jsdelivr.net/npm/workbox-cdn@3.6.3/workbox/',
  debug: false
});

if (workbox) {
  console.log(`Yay! Workbox is loaded 🎉`);
} else {
  console.log(`Boo! Workbox didn't load 😬`);
}

workbox.routing.setDefaultHandler(
  new workbox.strategies.NetworkFirst({
    options: [
      {
        // 超过 3s 请求没有响应则 fallback 到 cache
        networkTimeoutSeconds: 3
      }
    ]
  })
);

// 定义缓存版本号和默认 Cache Storage 条目数
let cacheSuffixVersion = '-200128';
const maxEntries = 100;

workbox.routing.registerRoute(
  /.*(\?|\&)skip_cache=true.*/,
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(
  /.*\?action.*/,
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(
  /.*&action.*/,
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(
  /.*wp-admin.*/,
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(
  /.*wp-login.*/,
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(
  /.*sitemap.*/,
  new workbox.strategies.NetworkOnly()
);

workbox.routing.registerRoute(/.*feed.*/, new workbox.strategies.NetworkOnly());

workbox.routing.registerRoute(/.*\.php/, new workbox.strategies.NetworkOnly());

// workbox.routing.registerRoute(
//     // 使用正则表达式匹配路由
//     /.*\.html.*/,
//     new workbox.strategies.CacheFirst({
//         // cache storage 名称和版本号
//         cacheName: 'html-cache' + cacheSuffixVersion,
//         plugins: [
//             // 使用 expiration 插件实现缓存条目数目和时间控制
//             new workbox.expiration.Plugin({
//                 // 最大保存项目
//                 maxEntries,
//                 // 缓存 7 天
//                 maxAgeSeconds: 7 * 24 * 60 * 60,
//             }),
//             // 使用 cacheableResponse 插件缓存状态码为 0 的请求
//             new workbox.cacheableResponse.Plugin({
//                 statuses: [0, 200],
//             }),
//         ]
//     })
// );

workbox.routing.registerRoute(
  // Cache Image File
  /.*\.(?:png|jpg|jpeg|svg|gif)/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: 'img-cache' + cacheSuffixVersion,
    plugins: [
      // 使用 expiration 插件实现缓存条目数目和时间控制
      new workbox.expiration.Plugin({
        // 最大保存项目
        maxEntries,
        // 缓存 30 天
        maxAgeSeconds: 30 * 24 * 60 * 60
      }),
      // 使用 cacheableResponse 插件缓存状态码为 0 的请求
      new workbox.cacheableResponse.Plugin({
        statuses: [0, 200]
      })
    ]
  })
);

workbox.routing.registerRoute(
  // Cache CSS & JS files
  /.*\.(css|js)/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: 'static-assets-cache' + cacheSuffixVersion,
    plugins: [
      // 使用 expiration 插件实现缓存条目数目和时间控制
      new workbox.expiration.Plugin({
        // 最大保存项目
        maxEntries,
        // 缓存 30 天
        maxAgeSeconds: 30 * 24 * 60 * 60
      }),
      // 使用 cacheableResponse 插件缓存状态码为 0 的请求
      new workbox.cacheableResponse.Plugin({
        statuses: [0, 200]
      })
    ]
  })
);

workbox.routing.registerRoute(
  // Cache Fonts files
  /.*\.(woff|woff2)/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: 'static-assets-cache' + cacheSuffixVersion,
    plugins: [
      // 使用 expiration 插件实现缓存条目数目和时间控制
      new workbox.expiration.Plugin({
        // 最大保存项目
        maxEntries,
        // 缓存 30 天
        maxAgeSeconds: 30 * 24 * 60 * 60
      }),
      // 使用 cacheableResponse 插件缓存状态码为 0 的请求
      new workbox.cacheableResponse.Plugin({
        statuses: [0, 200]
      })
    ]
  })
);

workbox.routing.registerRoute(
  new RegExp('^https://cdn.jsdelivr.net'),
  new workbox.strategies.CacheFirst({
    cacheName: 'static-lib' + cacheSuffixVersion,
    plugins: [
      new workbox.expiration.Plugin({
        maxAgeSeconds: 30 * 24 * 60 * 60
      }),
      new workbox.cacheableResponse.Plugin({
        statuses: [0, 200]
      })
    ]
  })
);

workbox.routing.registerRoute(
  new RegExp('https://origami.ixk.me.*'),
  new workbox.strategies.NetworkFirst({
    cacheName: 'global-site-cache' + cacheSuffixVersion,
    options: [
      {
        // 超过 3s 请求没有响应则 fallback 到 cache
        networkTimeoutSeconds: 3
      }
    ]
  })
);

workbox.skipWaiting();
workbox.clientsClaim();
