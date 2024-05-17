<?php
// This file was auto-generated from sdk-root/src/data/kinesis/2013-12-02/endpoint-rule-set-1.json
return [ 'version' => '1.0', 'parameters' => [ 'Region' => [ 'builtIn' => 'AWS::Region', 'required' => false, 'documentation' => 'The AWS region used to dispatch the request.', 'type' => 'String', ], 'UseDualStack' => [ 'builtIn' => 'AWS::UseDualStack', 'required' => true, 'default' => false, 'documentation' => 'When true, use the dual-stack endpoint. If the configured endpoint does not support dual-stack, dispatching the request MAY return an error.', 'type' => 'Boolean', ], 'UseFIPS' => [ 'builtIn' => 'AWS::UseFIPS', 'required' => true, 'default' => false, 'documentation' => 'When true, send this request to the FIPS-compliant regional endpoint. If the configured endpoint does not have a FIPS compliant endpoint, dispatching the request will return an error.', 'type' => 'Boolean', ], 'Endpoint' => [ 'builtIn' => 'SDK::Endpoint', 'required' => false, 'documentation' => 'Override the endpoint used to send this request', 'type' => 'String', ], 'StreamARN' => [ 'required' => false, 'documentation' => 'The ARN of the Kinesis stream', 'type' => 'String', ], 'OperationType' => [ 'required' => false, 'documentation' => 'Internal parameter to distinguish between Control/Data plane API and accordingly generate control/data plane endpoint', 'type' => 'String', ], 'ConsumerARN' => [ 'required' => false, 'documentation' => 'The ARN of the Kinesis consumer', 'type' => 'String', ], 'ResourceARN' => [ 'required' => false, 'documentation' => 'The ARN of the Kinesis resource', 'type' => 'String', ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'StreamARN', ], ], ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Endpoint', ], ], ], ], ], [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Region', ], ], ], [ 'fn' => 'aws.partition', 'argv' => [ [ 'ref' => 'Region', ], ], 'assign' => 'PartitionResult', ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-iso', ], ], ], ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-iso-b', ], ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'aws.parseArn', 'argv' => [ [ 'ref' => 'StreamARN', ], ], 'assign' => 'arn', ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isValidHostLabel', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'accountId', ], ], false, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isValidHostLabel', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'region', ], ], false, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'service', ], ], 'kinesis', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'resourceId[0]', ], 'assign' => 'arnType', ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'ref' => 'arnType', ], '', ], ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'ref' => 'arnType', ], 'stream', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], '{arn#partition}', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'OperationType', ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis-fips.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled, but this partition does not support DualStack.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled, but this partition does not support FIPS.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis-fips.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled but this partition does not support FIPS', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled but this partition does not support DualStack', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Operation Type is not set. Please contact service team for resolution.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Partition: {arn#partition} from ARN doesn\'t match with partition name: {PartitionResult#name}.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Kinesis ARNs don\'t support `{arnType}` arn types.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: No ARN type specified', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: The ARN was not for the Kinesis service, found: {arn#service}.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Invalid region.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Invalid account id.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Failed to parse ARN.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'ConsumerARN', ], ], ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Endpoint', ], ], ], ], ], [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Region', ], ], ], [ 'fn' => 'aws.partition', 'argv' => [ [ 'ref' => 'Region', ], ], 'assign' => 'PartitionResult', ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-iso', ], ], ], ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-iso-b', ], ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'aws.parseArn', 'argv' => [ [ 'ref' => 'ConsumerARN', ], ], 'assign' => 'arn', ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isValidHostLabel', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'accountId', ], ], false, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isValidHostLabel', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'region', ], ], false, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'service', ], ], 'kinesis', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'resourceId[0]', ], 'assign' => 'arnType', ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'ref' => 'arnType', ], '', ], ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'ref' => 'arnType', ], 'stream', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], '{arn#partition}', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'OperationType', ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis-fips.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled, but this partition does not support DualStack.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled, but this partition does not support FIPS.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis-fips.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled but this partition does not support FIPS', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled but this partition does not support DualStack', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Operation Type is not set. Please contact service team for resolution.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Partition: {arn#partition} from ARN doesn\'t match with partition name: {PartitionResult#name}.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Kinesis ARNs don\'t support `{arnType}` arn types.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: No ARN type specified', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: The ARN was not for the Kinesis service, found: {arn#service}.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Invalid region.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Invalid account id.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Failed to parse ARN.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'ResourceARN', ], ], ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Endpoint', ], ], ], ], ], [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Region', ], ], ], [ 'fn' => 'aws.partition', 'argv' => [ [ 'ref' => 'Region', ], ], 'assign' => 'PartitionResult', ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-iso', ], ], ], ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-iso-b', ], ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'aws.parseArn', 'argv' => [ [ 'ref' => 'ResourceARN', ], ], 'assign' => 'arn', ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isValidHostLabel', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'accountId', ], ], false, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isValidHostLabel', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'region', ], ], false, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'service', ], ], 'kinesis', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'arn', ], 'resourceId[0]', ], 'assign' => 'arnType', ], [ 'fn' => 'not', 'argv' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'ref' => 'arnType', ], '', ], ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'ref' => 'arnType', ], 'stream', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], '{arn#partition}', ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'OperationType', ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis-fips.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled, but this partition does not support DualStack.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled, but this partition does not support FIPS.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis-fips.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled but this partition does not support FIPS', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled but this partition does not support DualStack', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://{arn#accountId}.{OperationType}-kinesis.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Operation Type is not set. Please contact service team for resolution.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Partition: {arn#partition} from ARN doesn\'t match with partition name: {PartitionResult#name}.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Kinesis ARNs don\'t support `{arnType}` arn types.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: No ARN type specified', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: The ARN was not for the Kinesis service, found: {arn#service}.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Invalid region.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Invalid account id.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid ARN: Failed to parse ARN.', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Endpoint', ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], ], 'error' => 'Invalid Configuration: FIPS and custom endpoint are not supported', 'type' => 'error', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'error' => 'Invalid Configuration: Dualstack and custom endpoint are not supported', 'type' => 'error', ], [ 'conditions' => [], 'endpoint' => [ 'url' => [ 'ref' => 'Endpoint', ], 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'isSet', 'argv' => [ [ 'ref' => 'Region', ], ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'aws.partition', 'argv' => [ [ 'ref' => 'Region', ], ], 'assign' => 'PartitionResult', ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ true, [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], ], ], [ 'fn' => 'booleanEquals', 'argv' => [ true, [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://kinesis-fips.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS and DualStack are enabled, but this partition does not support one or both', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseFIPS', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsFIPS', ], ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'stringEquals', 'argv' => [ [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'name', ], ], 'aws-us-gov', ], ], ], 'endpoint' => [ 'url' => 'https://kinesis.{Region}.amazonaws.com', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://kinesis-fips.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'FIPS is enabled but this partition does not support FIPS', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ [ 'ref' => 'UseDualStack', ], true, ], ], ], 'rules' => [ [ 'conditions' => [ [ 'fn' => 'booleanEquals', 'argv' => [ true, [ 'fn' => 'getAttr', 'argv' => [ [ 'ref' => 'PartitionResult', ], 'supportsDualStack', ], ], ], ], ], 'rules' => [ [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://kinesis.{Region}.{PartitionResult#dualStackDnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'DualStack is enabled but this partition does not support DualStack', 'type' => 'error', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'endpoint' => [ 'url' => 'https://kinesis.{Region}.{PartitionResult#dnsSuffix}', 'properties' => [], 'headers' => [], ], 'type' => 'endpoint', ], ], 'type' => 'tree', ], ], 'type' => 'tree', ], [ 'conditions' => [], 'error' => 'Invalid Configuration: Missing Region', 'type' => 'error', ], ],];