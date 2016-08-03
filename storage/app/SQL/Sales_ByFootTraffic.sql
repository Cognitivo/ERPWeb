select (select sum(sid.quantity * sid.unit_price) as val
from sales_invoice as si
left join sales_invoice_detail as sid
on si.id_sales_invoice = sid.id_sales_invoice
where si.trans_date between @StartDate and @EndDate)/(select ifnull(sum(quantity),200) as val
from app_branch_walkins
where(start_date >= @StartDate and start_date <= @EndDate )
and(end_date >= @StartDate and end_date <= @EndDate )) as foottraffic
