# typage-php
### Easily validate data with type classes
 
<!--Typage-php has a lot to offer. -->

With a single definition you can validate your data, be that for input, output or testing.

With the same definition you can generate a description in a valid, human readable json format.
It's on the road map to be able to turn those jsons back to type checking instances

In case a checking fails you get an exception with an informative error message where the error happened and what went wrong.

Example:

`Value named: request:myArray[1] with data: "hallo asdf" does not conform to regex: /^\w+$/u`

or:

`Value named: request:myNumber has a value of 55 which is bigger then the maximum: 34.234`

You can easily add your own types by extending the AbstractAny class, or just using the Any class with a validation Closure.

Check out the tests folder, for usage examples, and mess around with it to see how this works.

A tiny exampe on how to use it:
```php
$validator = new Object(
    "myNumber0to10"       => new Integer(0, 10),
    "myStringArray"       => new ArrayList(new Text()),
    "singleWord"          => new Text("/^\w+$/u"),
    "optionalNumber"      => new Nullable(new Double()),
    "optionalWithDefault" => new Either(new Text(), "Hello World")
);

$validatedData = $validator->check($input, "request");
```


### Why this instead of JSON schema?
Above all that JSON schema provides, this library provides:

- All properties are Required by default
- Error handling is automatically done with exceptions, by default, no need to check the result for errors. 
- Null is not handled as meaningful data, a property must be explicitly declared Nullable.
- Easy to extend*.
- It's safer and easier to declare the type annotations, you always know what are the possible properties from the constructor's signature.
- It's in the same language and doesn't necessarily require a separate file.
- You can pass around validators in you application, without any concern, since they are regular immutable php Objects.
- We can generate a JSON schema from the definition** ;)

\* You can just grab the Any class and write a validator function, since sometimes you have to validate against the database. You can easily extend AbstractAny class, to create you own types.

**Syntax slightly differs
