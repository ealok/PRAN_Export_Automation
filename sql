update batch: 


UPDATE `batches` set is_end = 1  where date(created_at) < date('2019-01-01') AND is_end =0
