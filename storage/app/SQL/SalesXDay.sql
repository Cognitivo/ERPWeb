select (sid.unit_price * sid.quantity) as Sales,
date(trans_date) as Date,
b.name as Branch
from sales_invoice as si
inner join sales_invoice_detail as sid
on si.id_sales_invoice = sid.id_sales_invoice
left join app_branch as b
on si.id_branch = b.id_branch
where si.id_company = 1
and si.trans_date between @StartDate and @EndDate
group by date(trans_date)
order by date(trans_date)
