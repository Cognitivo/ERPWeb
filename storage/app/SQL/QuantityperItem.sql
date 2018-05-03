select items.name as item,
round(sum(quantity)) as quantity
from sales_invoice as si
left join sales_invoice_detail as sd
on si.id_sales_invoice = sd.id_sales_invoice

left join items
on items.id_item = sd.id_item
 where si.trans_date between @StartDate and @EndDate
group by  sd.id_item;
