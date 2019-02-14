importScripts('https://cdn.jsdelivr.net/npm/workbox-cdn@3.6.3/workbox/workbox-sw.js');
workbox.setConfig({
    modulePathPrefix:'https://cdn.jsdelivr.net/npm/workbox-cdn@3.6.3/workbox/'
});

if (workbox) {
  console.log(`Yay! Workbox is loaded 🎉`);
} else {
  console.log(`Boo! Workbox didn't load 😬`);
}

// 定义缓存版本号和默认 Cache Storage 条目数
let cacheSuffixVersion = '-190214';
const maxEntries = 100;

workbox.routing.registerRoute(
    // 使用正则表达式匹配路由
    /.*\.html'/,
    workbox.strategies.cacheFirst({
        // cache storage 名称和版本号
        cacheName: 'html-cache' + cacheSuffixVersion,
        plugins: [
            // 使用 expiration 插件实现缓存条目数目和时间控制
            new workbox.expiration.Plugin({
                // 最大保存项目
                maxEntries,
                // 缓存 7 天
                maxAgeSeconds: 7 * 24 * 60 * 60,
            }),
            // 使用 cacheableResponse 插件缓存状态码为 0 的请求
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
        ]
    })
);

workbox.routing.registerRoute(
    new RegExp('https://dev\.ixk\.me.*'),
    workbox.strategies.networkFirst({
        options: [{
            // 超过 3s 请求没有响应则 fallback 到 cache
            networkTimeoutSeconds: 3,
        }]
    })
);

workbox.routing.registerRoute(
    // Cache Image File
    /.*\.(?:png|jpg|jpeg|svg|gif)/,
    workbox.strategies.staleWhileRevalidate({
        cacheName: 'img-cache' + cacheSuffixVersion,
        plugins: [
            // 使用 expiration 插件实现缓存条目数目和时间控制
            new workbox.expiration.Plugin({
                // 最大保存项目
                maxEntries,
                // 缓存 30 天
                maxAgeSeconds: 30 * 24 * 60 * 60,
            }),
            // 使用 cacheableResponse 插件缓存状态码为 0 的请求
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
        ]
    })
);

workbox.routing.registerRoute(
    // Cache CSS & JS files
    /.*\.(css|js)/,
    workbox.strategies.staleWhileRevalidate({
        cacheName: 'static-assets-cache',
        plugins: [
            // 使用 expiration 插件实现缓存条目数目和时间控制
            new workbox.expiration.Plugin({
                // 最大保存项目
                maxEntries,
                // 缓存 30 天
                maxAgeSeconds: 30 * 24 * 60 * 60,
            }),
            // 使用 cacheableResponse 插件缓存状态码为 0 的请求
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
        ]
    })
);

workbox.routing.registerRoute(
    // Cache Fonts files
    /.*\.(woff|woff2)/,
    workbox.strategies.staleWhileRevalidate({
        cacheName: 'static-assets-cache',
        plugins: [
            // 使用 expiration 插件实现缓存条目数目和时间控制
            new workbox.expiration.Plugin({
                // 最大保存项目
                maxEntries,
                // 缓存 30 天
                maxAgeSeconds: 30 * 24 * 60 * 60,
            }),
            // 使用 cacheableResponse 插件缓存状态码为 0 的请求
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
        ]
    })
);

workbox.routing.registerRoute(
    /.*\?action.*/,
    workbox.strategies.networkFirst()
);

workbox.routing.registerRoute(
    /.*&action.*/,
    workbox.strategies.networkOnly()
);

workbox.routing.registerRoute(
    /.*wp-admin.*/,
    workbox.strategies.networkOnly()
);

workbox.routing.registerRoute(
    /.*wp-login.*/,
    workbox.strategies.networkOnly()
);

workbox.routing.registerRoute(
    /.*sitemap.*/,
    workbox.strategies.networkOnly()
);

workbox.routing.registerRoute(
    /.*feed.*/,
    workbox.strategies.networkOnly()
);

workbox.routing.registerRoute(
    /.*\.php/,
    workbox.strategies.networkOnly()
);

workbox.routing.registerRoute(
    /.*syfxlin.*/,
    workbox.strategies.networkOnly()
);

workbox.skipWaiting();
workbox.clientsClaim();
