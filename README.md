## 🔰 How to run project
To run the project, please execute the following command. If needed, you can modify the project's port in the `docker-compose.yml` file.
```bash
docker comopse up
```
Afterward, navigate to the Cloudflare dashboard, select your domain, enter the `origin rules` section, and click on `create rule`. Input the rule name, set the `field` to `hostname`, and enter your domain or subdomain. Click on `rewrite to`, and specify the project's port. Now, go to the `ssl/tls` section and click on `Flexible`.
### TODO
 - [x] write how to use
 - [ ] write a better readme.md :)
 - [ ] add discord module
