
select avg(salesperinvoice) as AvgSales
from (select sum(sid.quantity*sid.unit_price)as salesperinvoice , si.id_sales_invoice
from sales_invoice as si
left join sales_invoice_detail as sid
on si.id_sales_invoice = sid.id_sales_invoice
where si.trans_date between @StartDate and @EndDate
group by si.id_sales_invoice) as QuantityPerInvoice;
