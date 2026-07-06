# Deployment

## Production deployment checklist

1. Confirm PHP, Composer, Node build tooling if required, MySQL/Redis versions.
2. Configure `.env` securely.
3. Run `composer install --no-dev --optimize-autoloader`.
4. Run migrations.
5. Seed roles, permissions and default settings.
6. Generate application key.
7. Configure Sanctum stateful domains if needed.
8. Configure queue worker and Horizon.
9. Configure scheduler cron.
10. Configure storage link if public media is used.
11. Configure backups.
12. Configure log rotation.
13. Configure HTTPS and secure headers.
14. Run tests before release.
15. Generate OpenAPI docs.
16. Clear and cache config/routes/views.

## Commands

```bash
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force
php artisan optimize
php artisan queue:restart
php artisan schedule:list
```

## Monitoring

- `/api/v1/health`
- Horizon dashboard
- Application logs
- Failed jobs
- Database backups
- Queue depth
- Disk usage for media and reports
