# Has Identifier

## Installation

1. Add the brainstud group registry to `composer.json`

```
"repositories": {
    "3254464": {
        "type": "composer",
        "url": "https://gitlab.com/api/v4/group/3254464/-/packages/composer/"
    }
},
```

2. Add your gitlab token to the composer config

`composer config --global --auth gitlab-token.gitlab.com YOUR_TOKEN`

3. Require the package
`composer require brainstud/has-identifier`

4. Add the trait

`use HasIdentifier;`

## Updating

1. Update the code
2. Update the tag: `git tag v1.0.1`
3. Push the new tag `git push origin v1.0.1`
4. Publish the new version: `curl --data tag=v1.0.0 "https://<DEPLOY TOKEN SEE 1PASSWORD>:<YOUR API TOKEN>@gitlab.com/api/v4/projects/28242247/packages/composer"`
5. Check the [packages](https://gitlab.com/brainstud/packages/has-identifier/-/packages) page if it was successfull
6. Update the package in your project with composer
