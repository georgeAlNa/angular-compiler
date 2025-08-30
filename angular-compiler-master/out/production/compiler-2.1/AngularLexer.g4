lexer grammar AngularLexer;

// Whitespace and Comments
WS : [ \t\r\n]+ -> skip;
LINE_COMMENT : '//' ~[\r\n]* -> skip;
BLOCK_COMMENT : '/*' .*? '*/' -> skip;

// Angular-Specific Tokens
COMPONENT : '@Component';
SELECTOR : 'selector';
TEMPLATE : 'template';
STYLES : 'styles';
BACKTICK : '`';
TEMPLATE_EXPRESSION : '{{' .*? '}}';

// Structural Tokens
LCURLEBRACE : '{';
RCURLEBRACE : '}';
LSQBRACKET : '[';
RSQBRACKET : ']';
LPAREN : '(';
RPAREN : ')';
COLON : ':';
COMMA : ',';
DOT : '.';
SEMICOLON : ';';
STAR : '*';
SELF_CLOSE : '/>';
CLOSE_TAG : '</';
GT : '>';
LT : '<';
EQUAL : '=';
QUESTION_MARK : '?';

// Operators
PLUS : '+';
MINUS : '-';
SLASH : '/';
EQEQ : '==';
EQEQEQ : '===';
LESSOREQUAL : '<=';
GREATEROREQUAL : '>=';
NOTEQUAL : '!=';

// TypeScript Keywords
CLASS : 'class';
THIS: 'this';
CONST : 'const';
NULL : 'null';
LET : 'let';
VAR : 'var';
FUNCTION : 'function';
RETURN : 'return';
EXPORT : 'export';
IMPORT : 'import';
EXTENDS : 'extends';
IMPLEMENTS : 'implements';

// General Tokens
STRING : '"' (~["\\\r\n])* '"' | '\'' (~['\\\r\n])* '\'';
BOOLEAN : 'true' | 'false';
NUMBER : [0-9]+ ('.' [0-9]+)?;
IDENTIFIER : [a-zA-Z_][a-zA-Z0-9_]*;
ALPHABET_ONLY : [a-zA-Z]* ;


//CSS_PROPERTY : [a-zA-Z\-]+ ;
//CSS_VALUE
//    : PERCENTAGE
//    | ALPHABET_ONLY
//    ;

PERCENTAGE : [0-9]+ '%';

FUNCTION_VALUE : [a-zA-Z\-]+ '(' .*? ')';
COLOR : '#' [0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f] ([0-9A-Fa-f] [0-9A-Fa-f] [0-9A-Fa-f])? ;



// Angular-Specific Directives and Bindings
BINDING : LSQBRACKET IDENTIFIER RSQBRACKET;
EVENT_BINDING : LPAREN IDENTIFIER RPAREN;
STRUCTURAL_DIRECTIVE : STAR IDENTIFIER;

PROPERTY_BINDING : '[' IDENTIFIER ']' ;

// CSS Tokens
CSS_SELECTOR : [a-zA-Z0-9_#\-.]+ ;
