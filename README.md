# Phalcon - отслеживание запроса 

Библиотека для отслеживание запроса между сервисами

## Требуется
    - Phalcon > 3.0.0
    
## Использование

Генерирует для текущего запроса correlation_id и span_id, если их не было. Для следующего запроса надо подставить в 
query параметры correlation_id и span_id.

````php
$params = CorrelationId::getInstance()->getCurrentQueryParams();

$url = "https://example.com?correlation_id=$params['correlation_id']&span_id=$params['span_id']";
````
