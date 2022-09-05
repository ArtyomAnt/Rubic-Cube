### How to run app:

```bash
make install
```

## Endpoints:

### /generate/SIZE

* Generates a cube

```http request
POST http://localhost:8080/generate/3
```

### /getCube/ID

* Returns stored cube

```http request
GET http://localhost:8080/getCube/1
```
