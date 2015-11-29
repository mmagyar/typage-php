# typage-php
### Easily validate with type classes
 
Typage-php has a lot to offer. 
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