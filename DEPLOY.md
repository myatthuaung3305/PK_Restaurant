# Deploy Pandan Kitchen

## Render With Docker

1. Sign in to Render.
2. Click `New` -> `Web Service`.
3. Connect the GitHub repo:

   `myatthuaung3305/PK_Restaurant`

4. Use these settings:
   - Branch: `main`
   - Environment: `Docker`

5. Add environment variables if needed:
   - `APP_URL` = your Render service URL after deploy
   - `APP_ENV` = `production`
   - `APP_DEBUG` = `false`

6. Deploy the service.

## Notes

- `Dockerfile` and `entrypoint.sh` are already included.
- The container creates the SQLite database and runs migrations on startup.
- For a demo project this is acceptable, but a managed database is better for long-term deployment.
