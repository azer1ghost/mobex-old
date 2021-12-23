# `CFEX` API Reference - #v1

## REST APIs
The REST APIs provide programmatic access to read and write ASE package data. Create a new Package, read user and more. The REST API identifies warehouses using `ASE Private Key`. Contact us for APK.

## Overview
Below are the documents that will help you get going with the REST APIs as quickly as possible

 - [API Rate Limiting](#api-rate)
 - [Auth private key](#key)
 - [Member search](#user)
 - [Package](#package)
 	- [Add new one](#add)
 	- [Send it](#send)


## API Rate Limiting
Rate limiting of the API is primarily considered on a per-warehouse basis — or more accurately described, per access private key. If a method allows for 60 requests per rate limit window, then it allows you to make 60 requests per window per leveraged access key.

## Auth Private Key
ASE API auth with APK. ASE Private Key (APK) is self-contained way for securely transmitting information between us. This information can be verified and trusted because it is digitally signed for our system. **You have to send `key`  parameter at every request.**

## Introduction
All links are relative to **https://api.cfex.az/v1**. For ex. **/user** refers to **https://api.cfex.az/v1/user**.

## Response Status (Error) Information
| Value                  | Status |
|------------------------|--------|
| Any error. Bad request | 400    |
| Not Authenticated      | 401    |
| Route or page not found| 401    |
| Too Many Attempts      | 429    |
| Server error           | 500    |


## Member search
**[`GET`] `/user`**
### Parameters
`code` - ASE Member custom code. Ex : **ASE3120**

### Success Response
``` JSON
{
	"user": {
		"id": 1913,
		"full_name": "Yelena Shafizade",
		"code": "ASE3120"
	}
}
```

### Error Response
``` JSON
{
	"errors": "Member not found!"
}
```

## Package add
When new package arrived in your warehouse you should add it to our system as well.

**[`POST`] `/package/add`**
### Parameters

  - `tracking_code` => Can be null, but you should send it
  - `code` => Required when `user_id` is not present ::: **string** ::: **should exists in our members**, *Ex : ASE3120*
  - `user_id` => Required when `code` is not present ::: **integer** ::: **should exists in our members**, *Ex : 1913*
  - `weight` => required ::: numeric ::: min:0.1
  - `measurement_unit` => can skip it ::: default is kg ::: accept kg, lbs, stn
  - `width` => can be null ::: numeric
  - `height` => can be null ::: numeric
  - `length` => can be null ::: numeric
  - `length_unit` => can skip it ::: default is cm ::: accept cm, in

### Success Response
``` JSON
{
	"ase_package_id": "5a8fbef21d127", // Our custom package ID
	"tracking_code": "ZX8434FSD8323FF23232"
}
```

### Error Response
``` JSON
{
	"errors": {
		"code": [
			"The selected code is invalid."
		],
		"weight": [
			"The weight must be a number."
		],
		"measurement_unit": [
			"The selected measurement unit is invalid."
		]
	}
}
```


## Package send

Send a package our Baku store.

**[`POST`] `/package/send`**

### Parameters
- `tracking_code` => Required when `ase_package_id ` is not present ::: **string** ::: **should exists in our packages table**,
- `ase_package_id ` => Required when `tracking_code ` is not present ::: **string** ::: **should exists in our packages table**,

### Error Response
``` JSON
ex : 1
{
	"errors": {
		"tracking_code": [
			"The selected tracking code is invalid."
		]
	}
}

## ex : 2
{
	"errors": "The package has already sent"
}

## ex : 3
{
	"errors": "The package doesn't belong to your warehouse"
}
```
