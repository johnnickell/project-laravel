# Project context

Fight Laravel Starter is a public-source, Laravel-native application foundation. It composes public Fight Common and Fight AccessControl contracts without becoming their implementation home.

Laravel owns service-provider registration, container bindings, routing, HTTP responses, security, persistence, queues, realtime delivery, presentation, and operations. The starter boots the registered Fight Common platform services, including Laravel-native filesystem composition, SQLite transactional persistence, synchronous and queued messaging, cache, Blade, mail, process, and observability defaults. Application credentials, routes, templates, event mappings, policy, and Domain/Application services remain project-owned configuration and downstream work.

The current Fight Common candidate is Composer `dev-develop` at `cfb951c368f9b40fe460e931011b092d8eef6509`, consumed through the compatibility-only `1.2.0-dev` inline alias. The profile requires PHP 8.5. Its canonical `1.2.0-dev` receipt identity, HMAC PSR-7 signer, fail-closed security configuration, fresh lowest/latest dependency lanes, and final local gates are verified.
