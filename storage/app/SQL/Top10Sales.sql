select i.name as Item,
sum(sid.quantity * sid.unit_price) as Sales,
sum(sid.quantity * sid.unit_cost) as Costs
from sales_invoice as si
left join sales_invoice_detail as sid
on si.id_sales_invoice = sid.id_sales_invoice
left join items as i
on i.id_item = sid.id_item
where si.trans_date
between @StartDate and @EndDate
and si.id_company = 1
group by sid.id_item
order by sum(sid.quantity)
desc limit 10
