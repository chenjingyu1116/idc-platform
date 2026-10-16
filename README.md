# 🌸 樱花云 · 二次元 IDC 云管理平台

> 一个基于 **Laravel 12** 的二次元主题 IDC 云管理系统。覆盖用户下单 → 余额支付 → 自动开通 → 资源分配 → 续费/工单/代理/财务的完整业务闭环，可直接用于中小型 IDC 服务商运营。

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)
![UI](https://img.shields.io/badge/UI-二次元樱花主题-ff9ec4)

---

## 📖 项目简介

**樱花云** 是一个面向中小型 IDC 服务商的完整云管理平台。系统采用 **Laravel 12** 构建，前端使用 **Blade + Tailwind CSS**，整体 UI 采用 **二次元樱花主题**（粉紫渐变、樱花飘落、圆角卡片、萌系图标）。

系统后端采用 **适配器模式** 对接上游 API，可灵活切换手动交付或自动开通，方便接入 Novaix、IDCsmart、宝塔面板等上游系统。所有业务模块均已完整实现，可直接部署上线运营。

**核心特点**：

- 🎨 全站二次元主题（亮色 + 暗色模式）
- 🔌 适配器模式对接上游（一次开发，多方接入）
- ⚡ Redis 异步队列（下单秒级响应）
- 📧 真实邮件通知（SMTP 全链路）
- 🛡️ 完整权限隔离（客户端 / 管理端）
- 📊 数据看板 + 图表可视化

---

## ✨ 功能特性

### 🎀 客户端（前台）

#### 官网与认证
- 二次元主题官网首页（粒子背景 + 樱花飘落 + 数据统计）
- 背景图自动轮播（每 8 秒切换 + 浮动光晕）
- 弹幕动画（12 条预设消息从右往左飘）
- 用户注册 / 登录 / 密码找回 / 邮箱验证
- 注册成功自动发送欢迎邮件 + 站内信
- 深色模式切换 / 移动端适配

#### 产品与订单
- 产品列表（卡片式展示，配置清晰）
- 产品详情页（规格表 + FAQ + 推荐）
- 产品对比（多产品横向对比）
- 购物车（加购 / 修改数量 / 移除 / 清空）
- 优惠券实时预览（输入码立即显示折扣）
- 余额支付 + 订单管理 + 再次购买
- 订单历史列表 + 详情

#### 客户中心
- 我的服务：查看 IP / 账号 / 密码 / 到期时间
- 一键续费 / 暂停 / 恢复
- 充值申请（等待管理员审核）
- 工单系统（气泡对话 + 附件上传）
- 站内信通知中心
- 我的优惠券（可用 / 已使用分类）
- 代理中心（推荐码 / 下级 / 返佣 / 提现）
- 会员等级 / 积分

### 👑 管理后台

#### 数据与监控
- 数据看板（总用户 / 订单 / 收入 / 激活 / 待分配）
- 收入曲线图（最近 7 天）
- 订单趋势柱状图
- 新增用户曲线图
- 系统监控（数据库 / 队列 / 磁盘）

#### 业务管理
- 产品管理（增删改查 + 上下架）
- 产品映射（本地产品 ↔ 上游产品）
- 资源管理（手动分配 IP / 账号 / 密码）
- 充值审核（一键批准到账）
- 订单管理（详情 / 状态流转 / 导出 CSV）
- 用户管理（搜索 / 编辑 / 调整余额 / 重置密码 / 导出 CSV）
- 服务管理（列表 / 续费 / 暂停 / 恢复 / 终止）

#### 上游与适配器
- 上游管理（手动 / 宝塔 / Novaix / HTTP）
- 开通日志（全量记录 API 请求与响应）
- 产品映射配置

#### 内容与营销
- 公告管理（增删改查）
- 知识库（分类 + 文章）
- 优惠券管理（创建 + 指定发放 + 群体发放）
- 会员等级管理
- 代理管理（列表 / 提现审核 / 返佣明细）

#### 财务与审计
- 财务报表（收入统计 / 交易记录）
- 充值记录
- 审计日志（IP / UA / 前后值）
- 管理员账号管理
- 系统设置（站点 / 邮件 / 支付 / 备案 / 多语言）

---

## 🛠️ 技术栈

| 层级 | 技术 | 说明 |
|---|---|---|
| 后端框架 | Laravel 12 | 最新 LTS 版本 |
| PHP 版本 | 8.4 | 支持最新语法特性 |
| 数据库 | SQLite / MySQL | 开发 SQLite，生产 MySQL |
| 前端框架 | Blade + Tailwind CSS 3 | 服务端渲染 + CDN |
| 前端交互 | Alpine.js 3 | 轻量级交互 |
| 队列系统 | Redis + Laravel Queue | 异步开通任务 |
| 邮件系统 | SMTP | 网易 / QQ / 腾讯云 |
| 图表库 | Chart.js 4 | 数据可视化 |
| 认证系统 | Laravel Breeze | 标准认证脚手架 |
| 权限管理 | 自定义中间件 | admin / client 隔离 |
| 部署方式 | Docker / Docker Compose | 一键部署 |

---

## 📂 完整目录结构
idc-platform/
│
├── app/ # 应用核心代码
│ ├── Console/ # 命令行命令
│ │ └── Commands/ # 定时任务命令
│ │
│ ├── Http/ # HTTP 层
│ │ ├── Controllers/ # 控制器
│ │ │ ├── Controller.php # 基类
│ │ │ ├── OrderController.php # 下单
│ │ │ ├── ProfileController.php # 个人资料
│ │ │ ├── AnnouncementController.php # 公告（公开）
│ │ │ ├── KbController.php # 知识库（公开）
│ │ │ ├── SearchController.php # 搜索
│ │ │ ├── SitemapController.php # Sitemap
│ │ │ ├── RobotsController.php # Robots.txt
│ │ │ ├── LocaleController.php # 语言切换
│ │ │ │
│ │ │ ├── Admin/ # 后台控制器
│ │ │ │ ├── DashboardController.php # 看板
│ │ │ │ ├── ProductController.php # 产品管理
│ │ │ │ ├── ServiceController.php # 资源管理
│ │ │ │ ├── RechargeController.php # 充值审核
│ │ │ │ ├── ProviderController.php # 上游管理
│ │ │ │ ├── ProductMappingController.php# 产品映射
│ │ │ │ ├── ProvisionLogController.php # 开通日志
│ │ │ │ ├── OrderController.php # 订单管理
│ │ │ │ ├── UserController.php # 用户管理
│ │ │ │ ├── TicketController.php # 工单管理
│ │ │ │ ├── AnnouncementController.php # 公告管理
│ │ │ │ ├── KbController.php # 知识库管理
│ │ │ │ ├── CouponController.php # 优惠券管理
│ │ │ │ ├── AgentController.php # 代理管理
│ │ │ │ ├── WithdrawalController.php # 提现审核
│ │ │ │ ├── CommissionController.php # 返佣
│ │ │ │ ├── MemberLevelController.php # 会员等级
│ │ │ │ ├── PaymentConfigController.php # 支付配置
│ │ │ │ ├── SettingController.php # 系统设置
│ │ │ │ ├── ReportController.php # 报表
│ │ │ │ ├── MonitorController.php # 监控
│ │ │ │ ├── FinanceController.php # 财务
│ │ │ │ ├── AuditLogController.php # 审计日志
│ │ │ │ └── AdminUserController.php # 管理员账号
│ │ │ │
│ │ │ ├── Client/ # 客户端控制器
│ │ │ │ ├── ServiceController.php # 我的服务
│ │ │ │ ├── RechargeController.php # 充值
│ │ │ │ ├── TicketController.php # 工单
│ │ │ │ ├── NotificationController.php # 通知
│ │ │ │ ├── CartController.php # 购物车 ⭐
│ │ │ │ ├── AgentController.php # 代理中心
│ │ │ │ └── CouponController.php # 优惠券
│ │ │ │
│ │ │ ├── Auth/ # 认证控制器（Breeze）
│ │ │ │ ├── AuthenticatedSessionController.php
│ │ │ │ ├── RegisteredUserController.php # 含欢迎邮件 ⭐
│ │ │ │ ├── PasswordResetLinkController.php
│ │ │ │ ├── NewPasswordController.php
│ │ │ │ ├── PasswordController.php
│ │ │ │ ├── ConfirmablePasswordController.php
│ │ │ │ ├── EmailVerificationPromptController.php
│ │ │ │ ├── EmailVerificationNotificationController.php
│ │ │ │ └── VerifyEmailController.php
│ │ │ │
│ │ │ └── Api/ # API 控制器
│ │ │ ├── ApiController.php
│ │ │ └── TokenController.php
│ │ │
│ │ ├── Middleware/ # 中间件
│ │ │ └── IsAdmin.php # 管理员权限校验
│ │ │
│ │ └── Requests/ # 表单验证请求
│ │ ├── ProfileUpdateRequest.php
│ │ └── Auth/LoginRequest.php
│ │
│ ├── Jobs/ # 队列任务
│ │ └── ProvisionService.php # 开通服务（异步）
│ │
│ ├── Models/ # Eloquent 模型
│ │ ├── User.php # 用户
│ │ ├── Product.php # 产品
│ │ ├── Order.php # 订单
│ │ ├── Service.php # 服务实例
│ │ ├── Provider.php # 上游供应商
│ │ ├── ProductMapping.php # 产品映射
│ │ ├── ProvisionLog.php # 开通日志
│ │ ├── Recharge.php # 充值
│ │ ├── Transaction.php # 交易
│ │ ├── Invoice.php # 发票
│ │ ├── Ticket.php # 工单
│ │ ├── TicketReply.php # 工单回复
│ │ ├── Announcement.php # 公告
│ │ ├── KbCategory.php # 知识库分类
│ │ ├── KbArticle.php # 知识库文章
│ │ ├── Coupon.php # 优惠券 ⭐
│ │ ├── UserCoupon.php # 用户优惠券 ⭐
│ │ ├── Agent.php # 代理
│ │ ├── Commission.php # 返佣
│ │ ├── Withdrawal.php # 提现
│ │ ├── MemberLevel.php # 会员等级
│ │ ├── Setting.php # 系统设置
│ │ ├── AuditLog.php # 审计日志
│ │ └── ApiToken.php # API Token
│ │
│ ├── Notifications/ # 通知类（邮件 + 站内信）
│ │ ├── WelcomeUser.php # 注册欢迎 ⭐
│ │ ├── OrderCreated.php # 下单成功
│ │ ├── OrderPaidNotification.php # 支付成功
│ │ ├── ServiceProvisioned.php # 服务开通
│ │ ├── ServiceActivated.php # 服务激活
│ │ ├── ServiceExpiringNotification.php # 服务到期
│ │ ├── ExpiringSoon.php # 即将到期
│ │ └── TicketReplied.php # 工单回复
│ │
│ ├── Providers/ # Laravel 服务提供者
│ │ └── AppServiceProvider.php
│ │
│ └── Services/ # 业务服务层
│ ├── Payment/ # 支付服务
│ │ └── EpayService.php # 易支付
│ │
│ └── Providers/ # ⭐ 上游适配器层（核心）
│ ├── ProvisioningInterface.php # 统一接口
│ ├── ProviderFactory.php # 工厂（动态选择）
│ ├── ManualProvider.php # 手动分配
│ ├── BtPanelProvider.php # 宝塔面板
│ ├── NovaixProvider.php # Novaix
│ └── HttpProvider.php # 通用 HTTP
│
├── bootstrap/ # 应用启动
│ ├── app.php # 应用配置（中间件注册）
│ └── cache/ # 缓存文件
│
├── config/ # 配置文件
│ ├── app.php
│ ├── auth.php
│ ├── cache.php
│ ├── database.php
│ ├── mail.php # 邮件配置
│ ├── queue.php # 队列配置
│ ├── services.php
│ └── session.php
│
├── database/ # 数据库
│ ├── database.sqlite # SQLite 数据库文件
│ ├── factories/ # 数据工厂
│ ├── migrations/ # 数据表迁移
│ │ ├── 2026_10_14_000001_create_users_table.php
│ │ ├── 2026_10_14_000002_create_cache_table.php
│ │ ├── 2026_10_14_000003_create_jobs_table.php
│ │ ├── 2026_10_14_000004_create_products_table.php
│ │ ├── 2026_10_14_000005_create_providers_table.php
│ │ ├── 2026_10_14_000006_create_orders_table.php
│ │ ├── 2026_10_14_000007_create_services_table.php
│ │ ├── 2026_10_14_000008_create_recharges_table.php
│ │ ├── 2026_10_14_000009_create_tickets_table.php
│ │ ├── 2026_10_14_000010_create_transactions_table.php
│ │ ├── 2026_10_14_000011_create_invoices_table.php
│ │ ├── 2026_10_14_000012_create_renewals_table.php
│ │ ├── 2026_10_14_000013_create_product_mappings_table.php
│ │ ├── 2026_10_14_000014_create_provision_logs_table.php
│ │ ├── 2026_10_14_000015_create_announcements_table.php
│ │ ├── 2026_10_14_000016_create_notification_logs_table.php
│ │ ├── 2026_10_14_000020_create_settings_table.php
│ │ ├── 2026_10_14_000030_create_agents_table.php
│ │ ├── 2026_10_14_000031_create_commissions_table.php
│ │ ├── 2026_10_14_000032_create_withdrawals_table.php
│ │ ├── 2026_10_14_000033_create_member_levels_table.php
│ │ ├── 2026_10_14_000034_create_coupons_table.php
│ │ ├── 2026_10_14_000050_create_audit_logs_table.php
│ │ ├── 2026_10_14_0000xx_create_ticket_replies_table.php
│ │ ├── 2026_10_14_0000xx_create_kb_tables.php
│ │ ├── 2026_10_14_0000xx_create_api_tokens_table.php
│ │ ├── 2026_10_14_0000xx_create_user_coupons_table.php ⭐
│ │ └── 2026_10_16_100000_add_coupon_to_orders.php ⭐
│ │
│ └── seeders/
│ └── DatabaseSeeder.php # 测试数据填充
│
├── docker/ # Docker 配置
│ ├── nginx/
│ │ └── default.conf # Nginx 站点配置
│ ├── php/
│ │ └── local.ini # PHP 配置
│ └── supervisord.conf # Supervisor 配置
│
├── public/ # Web 根目录
│ ├── index.php # 入口文件
│ ├── .htaccess
│ ├── backgrounds/ # 背景图资源 ⭐
│ │ ├── bg1.jpg
│ │ ├── bg2.jpg
│ │ └── bg3.jpg
│ └── storage/ # 存储软链接
│
├── resources/ # 资源文件
│ ├── css/
│ │ └── app.css
│ ├── js/
│ │ ├── app.js
│ │ └── bootstrap.js
│ │
│ └── views/ # Blade 视图
│ ├── welcome.blade.php # 官网首页 ⭐
│ ├── dashboard.blade.php
│ ├── search.blade.php # 搜索结果
│ ├── sitemap.blade.php # 站点地图
│ │
│ ├── layouts/ # 布局
│ │ ├── app.blade.php # 客户端布局（含背景+弹幕）⭐
│ │ ├── guest.blade.php # 认证布局（含背景+弹幕）
│ │ └── navigation.blade.php
│ │
│ ├── components/ # 组件
│ │ ├── application-logo.blade.php
│ │ ├── auth-session-status.blade.php
│ │ ├── background-slider.blade.php # ⭐ 背景轮播组件
│ │ ├── danmaku.blade.php # ⭐ 弹幕组件
│ │ ├── site-footer.blade.php # 共享页脚
│ │ ├── theme-vars.blade.php # 主题变量
│ │ ├── toast.blade.php # Toast 通知
│ │ ├── loading.blade.php # 加载动画
│ │ ├── chart.blade.php # 图表组件
│ │ ├── danger-button.blade.php
│ │ ├── dropdown.blade.php
│ │ ├── dropdown-link.blade.php
│ │ ├── input-error.blade.php
│ │ ├── input-label.blade.php
│ │ ├── modal.blade.php
│ │ ├── nav-link.blade.php
│ │ ├── primary-button.blade.php
│ │ ├── responsive-nav-link.blade.php
│ │ ├── secondary-button.blade.php
│ │ └── text-input.blade.php
│ │
│ ├── orders/
│ │ └── index.blade.php # 产品列表
│ │
│ ├── product/
│ │ └── show.blade.php # 产品详情
│ │
│ ├── cart/
│ │ └── index.blade.php # 购物车（含优惠券实时预览）⭐
│ │
│ ├── client/ # 客户端视图
│ │ ├── services/
│ │ │ ├── index.blade.php
│ │ │ └── show.blade.php
│ │ ├── recharge/
│ │ │ └── index.blade.php
│ │ ├── tickets/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── show.blade.php
│ │ ├── notifications/
│ │ │ └── index.blade.php
│ │ ├── coupons/
│ │ │ └── index.blade.php # 我的优惠券 ⭐
│ │ ├── agent/
│ │ │ └── index.blade.php # 代理中心
│ │ ├── member/
│ │ │ └── index.blade.php
│ │ ├── orders/
│ │ │ ├── index.blade.php
│ │ │ └── show.blade.php
│ │ ├── renew/
│ │ │ └── index.blade.php
│ │ ├── withdrawal/
│ │ │ └── index.blade.php
│ │ └── cart/
│ │ └── index.blade.php # ⭐ 实际使用的购物车视图
│ │
│ ├── admin/ # 后台视图
│ │ ├── dashboard.blade.php # 数据看板
│ │ ├── products/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── edit.blade.php
│ │ ├── services/
│ │ │ ├── index.blade.php
│ │ │ └── edit.blade.php
│ │ ├── recharges/
│ │ │ └── index.blade.php
│ │ ├── providers/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── edit.blade.php
│ │ ├── product-mappings/
│ │ │ ├── index.blade.php
│ │ │ └── create.blade.php
│ │ ├── provision-logs/
│ │ │ └── index.blade.php
│ │ ├── orders/
│ │ │ ├── index.blade.php
│ │ │ └── show.blade.php
│ │ ├── users/
│ │ │ ├── index.blade.php # 含搜索 ⭐
│ │ │ ├── edit.blade.php
│ │ │ └── show.blade.php
│ │ ├── tickets/
│ │ │ ├── index.blade.php
│ │ │ └── show.blade.php
│ │ ├── announcements/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── edit.blade.php
│ │ ├── kb/
│ │ │ ├── index.blade.php
│ │ │ ├── create-category.blade.php
│ │ │ └── create-article.blade.php
│ │ ├── coupons/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── distribute.blade.php # 优惠券发放 ⭐
│ │ ├── agents/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── withdrawals.blade.php
│ │ ├── levels/
│ │ │ └── index.blade.php
│ │ ├── payments/
│ │ │ ├── index.blade.php
│ │ │ ├── create.blade.php
│ │ │ └── edit.blade.php
│ │ ├── payment-configs/
│ │ │ └── index.blade.php
│ │ ├── reports/
│ │ │ └── index.blade.php
│ │ ├── monitor/
│ │ │ └── index.blade.php
│ │ ├── finance/
│ │ │ └── index.blade.php
│ │ ├── settings/
│ │ │ └── index.blade.php
│ │ ├── audit-logs/
│ │ │ ├── index.blade.php
│ │ │ └── login.blade.php
│ │ ├── withdrawals/
│ │ │ └── index.blade.php
│ │ └── admins/
│ │ └── index.blade.php
│ │
│ ├── auth/ # 认证视图（Breeze）
│ │ ├── login.blade.php
│ │ ├── register.blade.php
│ │ ├── forgot-password.blade.php
│ │ ├── reset-password.blade.php
│ │ ├── confirm-password.blade.php
│ │ └── verify-email.blade.php
│ │
│ ├── profile/ # 个人资料
│ │ ├── edit.blade.php
│ │ └── partials/
│ │ ├── update-profile-information-form.blade.php
│ │ ├── update-password-form.blade.php
│ │ └── delete-user-form.blade.php
│ │
│ ├── kb/ # 知识库（公开）
│ │ ├── index.blade.php
│ │ ├── category.blade.php
│ │ └── show.blade.php
│ │
│ ├── announcements/ # 公告（公开）
│ │ ├── index.blade.php
│ │ └── show.blade.php
│ │
│ └── errors/ # 错误页
│ ├── 403.blade.php
│ ├── 404.blade.php
│ ├── 500.blade.php
│ └── 503.blade.php
│
├── routes/ # 路由
│ ├── web.php # Web 路由
│ ├── auth.php # 认证路由（Breeze）
│ ├── api.php # API 路由
│ └── console.php # 命令行路由
│
├── storage/ # 存储
│ ├── app/
│ │ └── public/ # 公开文件（工单附件）
│ ├── framework/
│ │ ├── cache/
│ │ ├── sessions/
│ │ └── views/ # Blade 编译缓存
│ └── logs/
│ └── laravel.log # 日志文件
│
├── tests/ # 测试
│ ├── Feature/
│ └── Unit/
│
├── .env # 环境变量（不提交）
├── .env.example # 环境变量示例
├── .gitignore
├── artisan # Artisan 命令入口
├── composer.json # PHP 依赖
├── composer.lock
├── package.json # Node 依赖
├── phpunit.xml
├── vite.config.js
├── tailwind.config.js
├── postcss.config.js
├── deploy.sh # 部署脚本
├── docker-compose.yml # Docker 编排
├── Dockerfile # Docker 镜像
└── README.md # 本文档
text


---

## 🚀 快速开始

### 环境要求

- PHP >= 8.4
- Composer 2.x
- Node.js >= 18（可选，用于前端资源编译）
- SQLite 或 MySQL
- Redis（推荐，用于队列）

### 1. 克隆项目

```bash
git clone https://github.com/chenjingyu1116/idc-platform.git
cd idc-platform

2. 安装依赖
bash

composer install

3. 配置环境
bash

cp .env.example .env
php artisan key:generate

4. 编辑 .env
env

APP_NAME="樱花云"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8081

# 数据库（SQLite 开发）
DB_CONNECTION=sqlite

# Redis 队列
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# 邮件（以 163 为例）
MAIL_MAILER=smtp
MAIL_HOST=smtp.163.com
MAIL_PORT=465
MAIL_USERNAME=your@163.com
MAIL_PASSWORD=your_smtp_authorization_code
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="your@163.com"
MAIL_FROM_NAME="樱花云"

5. 初始化数据库
bash

touch database/database.sqlite
php artisan migrate:fresh --seed

6. 启动服务
bash

# 终端 1：启动 Web 服务
php artisan serve --host=0.0.0.0 --port=8000

# 终端 2：启动队列 Worker
php artisan queue:work redis

访问 http://localhost:8000
🔑 默认账号
角色	邮箱	密码	说明
管理员	admin@idc.local	password	可访问 /admin/*
普通用户	test@idc.local	password	余额 ¥1000
🎯 上游对接说明

系统采用 适配器模式 对接上游 API。所有上游适配器实现 ProvisioningInterface 接口：
php

interface ProvisioningInterface
{
    public function provision(Service $service): array;   // 开通
    public function suspend(Service $service): bool;      // 暂停
    public function unsuspend(Service $service): bool;    // 恢复
    public function terminate(Service $service): bool;    // 终止
    public function getStatus(Service $service): string;  // 查询状态
    public function getProducts(): array;                 // 获取产品列表
}

已实现的上游
驱动	说明	状态
manual	手动分配（管理员后台填 IP/账号/密码）	✅
bt_panel	宝塔面板 API	✅
novaix	Novaix 云平台 API	✅
http	通用 HTTP API（适配任意上游）	✅
接入新上游

    在 app/Services/Providers/ 创建 YourProvider.php

    实现 ProvisioningInterface 接口

    在 ProviderFactory.php 中注册

    后台添加对应驱动的上游

核心业务代码零改动。
📅 开发进度
✅ 已完成（B1~B13）
批次	模块
B1	核心骨架 + 二次元主题 UI
B2	支付 + 订单 + 收银台
B3	上游对接 + 自动开通 + 续费
B4	工单 + 公告 + 通知 + 知识库
B5	代理 + 返佣 + 提现 + 会员 + 优惠券
B6	系统设置 + 报表 + 监控 + 多语言
B7	API 开放平台 + 安全审计
B8	SEO + Sitemap + Robots + 搜索
B9	审计日志 + 提现审核 + 财务 + 管理员
B10	UI/UX 优化 + Toast + 图表 + 深色模式
B11	数据导出 + 移动端 + 工单气泡 + 产品详情 + 全局动效
B12	邮件通知系统 + 注册欢迎邮件
B13	Redis 队列 + 异步开通
附加	背景轮播 + 弹幕 + FAQ 折叠 + 用户搜索 + 优惠券发放
⏳ 待开发（B14~B20）
批次	模块
B14	Docker Compose 生产部署
B15	真实支付（易支付 / 支付宝 / 微信）
B16	发票管理（增值税普票 / 专票）
B17	白标 / OEM（代理商自定义品牌）
B18	多语言（中英文切换）
B19	续费到期邮件定时提醒
B20	订单 PDF 发票下载
🔒 安全特性
特性	实现
CSRF 保护	Laravel 内置 Token
SQL 注入防护	Eloquent ORM 参数绑定
XSS 过滤	Blade 自动转义
密码加密	bcrypt 单向哈希
权限隔离	IsAdmin 中间件
审计日志	全操作留痕（IP / UA / 前后值）
速率限制	登录 5次/分钟、API 60次/分钟
凭据加密	上游密钥使用 encrypted 存储
HTTPS	生产环境强制
敏感字段	密码字段 hidden 隐藏
🐳 Docker 部署
bash

# 一键启动全部服务
bash deploy.sh up

# 查看日志
bash deploy.sh logs

# 查看状态
bash deploy.sh status

# 停止
bash deploy.sh down

包含服务：

    Nginx 1.24

    PHP-FPM 8.4

    MySQL 8.0

    Redis 7

    Laravel Queue Worker

📊 数据看板

后台 /admin/dashboard 提供：

    统计卡片：总用户 / 总订单 / 总收入 / 已激活 / 待分配

    收入曲线：最近 7 天收入趋势（折线图）

    订单趋势：最近 7 天订单量（柱状图）

    用户增长：最近 7 天新增用户（折线图）

🎨 UI/UX 特性
特性	说明
主题配色	樱花粉 + 天空蓝 + 梦幻紫
字体	ZCOOL KuaiLe + Quicksand
背景	自动轮播（8 秒切换）
弹幕	12 条消息从右往左飘
光晕	紫蓝浮动光晕
动画	卡片淡入、数字滚动、按钮波纹
深色模式	右上角一键切换
移动端	汉堡菜单 + 响应式布局
加载动画	樱花旋转
Toast	操作成功/失败自动弹出
🤝 贡献指南

    Fork 本仓库

    创建分支 git checkout -b feature/your-feature

    提交改动 git commit -m 'feat: xxx'

    推送分支 git push origin feature/your-feature

    提交 Pull Request

📞 联系方式

    项目地址：https://github.com/chenjingyu1116/idc-platform

    问题反馈：提交 Issue

    商业合作：联系作者

📄 开源协议

MIT License
🙏 致谢

    Laravel

    Tailwind CSS

    Chart.js

    Alpine.js

    Laravel Breeze

🌸 樱花云 · 让 IDC 管理也能如此可爱！