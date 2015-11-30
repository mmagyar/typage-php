<pre style="font-size: 1em;">
<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com */
require "../vendor/autoload.php";
use mmagyar\type\Any;
use mmagyar\type\ArrayList;
use mmagyar\type\Boolean;
use mmagyar\type\Double;
use mmagyar\type\Either;
use mmagyar\type\Integer;
use mmagyar\type\None;
use mmagyar\type\Nullable;
use mmagyar\type\Object;
use mmagyar\type\Text;
use mmagyar\type\Type;
use mmagyar\type\TypeDescription;
use mmagyar\type\Union;


echo "testing types\n";

//Usually Object is your base type for requests. You can freely nest Object Type.
//It will accept both php objects and arrays.
$type = new Object([

    //Double means double precision floating point number, and it can have a set range
    'myNumber'        => new Double(0.2, 34.234),

    //An array where elements are bigger or equal 0
    'myArray'         => new ArrayList(
        new Integer(0)
    ),

    //Union types can accept multiple type of values under the same property
    'myUnion'         => new Union(
        [new Text(), new Integer()]
    ),

    //Or multiple ranges
    'myUnionRange'    => new Union(
        [new Integer(2, 23), new Integer(100, 133)]
    ),

    //An array where elements may be Text (strings) conforming to a regex: "/^\w+$/u" or Integers between (inclusive) 5 and 10
    'myUnionArray'    => new ArrayList(
        new Union(
            [new Text("/^\w+$/u"), new Integer(5, 10)]
        )
    ),

    //Either type of Boolean, if it's not submitted or null, it will default to a given value, false in this case
    'myEither'        => new Either(
        new Boolean(), false
    ),

    //Either only returns default if the property is null or absent, but still checks the type,
    // if the 'defaultOnWrongType' is set, it will return the default value if the submitted type is wrong (or out of range)
    'myEitherComplex' => new Either(
        new Double(3, 4), 3.3, true
    ),

    //None type does not contain any information, it's only a clear signal of absent data, it will ALWAYS return null
    //This is mostly for internal use, not very useful here.
    'myNone'          => new None(),

    //Nullable means that the variable can be null
    'myNullable'      => new Nullable(
        new Double()
    ),

    //Any type, it will accept any value (or even null if you set allowNull to true)
    //You can validate it with a closure,
    // Don't forget to call and return `handleTypeError` function in case your validation fails
    // otherwise your type might not work well with nested types
    // You have to supply your own TypeDescription
    //Use it only for very special types, for more general ones, extend AbstractAny
    'mySpecialAny'    => new Any(new TypeDescription("EvenNumber"), function ($value, $variableName, $soft) {
        if (!is_int($value) || !($value % 2 == 0)) return Type::handleTypeError("EvenNumber", $value, $variableName, $soft);
        return $value;
    })
]);

//After you finished declaring your variables you can get the type definition in valid JSON format
echo "\n\nThe type definition\n\n";
echo $type->getTypeString();

//Here is a test array simulating input data, try to change it, break, see what happens, learning by doing is the best!
//
$data = [
    'myArray'         => [234, 235235, 356, 356, 234234, 234],
    'myUnionArray'    => ["immafirst", "these_strings_must_be_single_words_validated_by_regex", 10, 5],
    'myEither'        => true,
    'myEitherComplex' => 55,
    'myUnionRange'    => 111,
    'myUnion'         => 'this could be an int as well, like 22',
    'myNumber'        => 22,
    'myNone'          => "You will not see this string after validation",
    'myNullable'      => "32.3",
    'mySpecialAny'    => 56

];
echo "\n\nData before checking\n\n";
echo json_encode($data, JSON_PRETTY_PRINT);


//To check the data structure, you only need to call the  check method of the Type definition,
// and optionally give a name to it, to personalise error messages
//Don't forget to grab the output of the function. The original request array or object will not be modified.
//Defaults will be added here, and types will be corrected if they are misaligned
//string(3) "234" will become int 234 if Integer type was defined, or float 234.00 if Double was used
//You can turn this off in a Number class static property called $strictNumberCheck
$result=null;
try {
    $result = $type->check($data, 'request');
} catch (Exception $e) {
    echo "</pre><h3>";
    echo $e->getMessage();
    echo "</h3><pre>";
}
echo "\n\nData after checking\n\n";
//Print the result to see how the checking transforms the data.
echo json_encode($result, JSON_PRETTY_PRINT);


?>
    </pre>
