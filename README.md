![screenshot](https://raw.githubusercontent.com/syfxlin/origami/master/screenshot.png)

> 简洁，轻快

![Version](https://img.shields.io/github/release/syfxlin/origami.svg?label=Version&style=flat-square) ![Author](https://img.shields.io/badge/Author-Otstar%20Lin-blue.svg?style=flat-square) ![WordPress](https://img.shields.io/badge/WordPress-4.4%2B-orange.svg?style=flat-square) ![PHP](https://img.shields.io/badge/php-5.6%2B-green.svg?style=flat-square) ![license](https://img.shields.io/badge/license-GPL%20v3-orange.svg?style=flat-square)

------

## 目录 Contents

- [目录 Contents](#%E7%9B%AE%E5%BD%95-contents)
- [简介 Introduction](#%E7%AE%80%E4%BB%8B-introduction)
- [Feature 特性](#feature-%E7%89%B9%E6%80%A7)
- [Loading speed 加载速度](#loading-speed-%E5%8A%A0%E8%BD%BD%E9%80%9F%E5%BA%A6)
- [演示 Demo](#%E6%BC%94%E7%A4%BA-demo)
- [安装 Install](#%E5%AE%89%E8%A3%85-install)
- [文档 Docs](#%E6%96%87%E6%A1%A3-docs)
- [维护者 Maintainer](#%E7%BB%B4%E6%8A%A4%E8%80%85-maintainer)
- [许可证 License](#%E8%AE%B8%E5%8F%AF%E8%AF%81-license)

## 简介 Introduction

Origami - 一个拥有许多强大功能，简洁，轻快的WordPress主题

## Feature 特性
- [独家] 评论完全动态加载（包括首次加载），可在完全静态化的情况下加载评论
- Ajax提交评论
- 实时搜索 – [后端处理数据]
- WorkBox注册和卸载
- OwO表情
- 页脚显示建站至今的时间
- 评论者标注（站长，友链认证）
- 6个短代码，多种页面模板
- 可视化编辑器和文本编辑器添加短代码
- 阅读转移
- 代码高亮
- 文章目录
- ImgBox
- 代码块新窗口显示
- 评论页面选单
- …

## Loading speed 加载速度

- Gtmetrix：100%(Pagespeed) 97%(YSlow) 0.6s(加载时间)
- Lighthouse：100%(Desktop) 100%(Mobile)
- web.dev：99%
- Loading time：946ms(第一次加载) 187ms(第二次加载，即有缓存情况)

## 演示 Demo

- [青空之蓝](https://blog.ixk.me)
- [Origami Demo](https://origami.ixk.me)

## 安装 Install

前往 [Releases](https://github.com/syfxlin/origami/releases) 下载，然后上传到WordPress中，确保主题文件夹名称为Origami

首次安装请先将主题自定义中的【Origami主题设置】选项卡里面的设置全部设置一遍

若要启用WordBox，请先将主题文件夹下的js文件夹中的sw.js复制至WordPress根目录

> 已经修复了WorkBox的缓存规则，这里说明一下，启用WorkBox会使用户的浏览器的请求完全被WorkBox接管，一旦启用后，页面的加载速度将得到质的提升，但是若要删除就必须加载卸载WorkBox的js，否则用户访问的页面将不会更新

> 若站点使用https，同时又需要引用http的资源，请将`header.php`文件中的`<meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">`字段删除。

## 文档 Docs

[Wiki](https://github.com/syfxlin/origami/wiki)

## 维护者 Maintainer

Origami主题 由 [Otstar Lin](https://ixk.me)和下列[贡献者](https://github.com/syfxlin/origami/graphs/contributors)的帮助下撰写和维护。

> Otstar Lin - [Personal Website](https://ixk.me)· [Blog](https://blog.ixk.me)· [Github](https://github.com/syfxlin)

## 许可证 License

![license](https://img.shields.io/badge/license-GPL%20v3-orange.svg?style=flat-square)

根据 GPL V3.0 许可证开源。

