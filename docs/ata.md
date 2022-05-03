## Ata

> Tabela ata
```
#id: int
assunto: string
datahora: datetime
descricao: longtext
```

> Tabela atacondomino
```
#id: int
@ata: int
@condomino: int
ciente: varchar[1] 'S' ou 'N' default 'N'
datahora: datetime
```

> HTTP Routes
* GET /ata (application/json)
	* Response (application/json)
```json
[
	{
		"id": 1,
		"assunto": "Assunto 1",
		"datahora": "2020-01-01 00:00:00",
		"descricao": "Descrição 1"
	},
	{
		"id": 2,
		"assunto": "Assunto 2",
		"datahora": "2020-08-01 00:00:00",
		"descricao": "Descrição 2"
	}
]
````

* GET /ata/:id/ (application/json)
	* Response (application/json)
```json
{
	"id": 1,
	"assunto": "Assunto 1",
	"datahora": "2020-01-01 00:00:00",
	"descricao": "Descrição 1",
	"condominos": [
		{
			"id": 1,
			"nome": "Nome 1",
			"ciente": "S"
		},
		{
			"id": 2,
			"nome": "Nome 2",
			"ciente": "N"
		}
	]
}
```

* GET /ata/:id/condomino/:condomino (application/json)
	* Response (application/json)
	- Retorna apenas atas que o condomino nao está ciente
```json
{
	[
		{
			id: 1,
			assunto: "Assunto 1",
			datahora: "2020-01-01 00:00:00",
			descricao: "Descrição 1"
		},
		{
			id: 2,
			assunto: "Assunto 2",
			datahora: "2020-01-01 00:00:00",
			descricao: "Descrição 2"
		}
	]
}
```

* POST /ata (application/json)
	* Request
```json
{
	"assunto": "Assunto 1",
	"descricao": "Descrição 1"
}
```

* Response (application/json)

```json
{
	message: "Ata criada com sucesso"
}
```

> PUT /ata/:id (application/json)

* Request
```json
{
	"assunto": "Assunto 1",
	"descricao": "Descrição 1"
}
```

> PUT /ata/:id/condomino/:condomino (application/json)
* Request
```json
{
	"ciente": "S"
}
```
* Response
```json
{
	message: "Ata atualizada com sucesso"
}
```

* Reponse (application/json)

```json
{
	message: "Registro atualizado com sucesso"
}
```

> DELETE /ata/:id

* Response (application/json)

```json
{
	message: "Ata excluída com sucesso"
}
```
