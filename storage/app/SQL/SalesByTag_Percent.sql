select it.name as Tag,
round((sum(quantity * unit_price) / ( select sum(quantity * unit_price)
                                      from sales_invoice as si1
                                      left join sales_invoice_detail as sid1
                                      on si1.id_sales_invoice = sid1.id_sales_invoice
                                      where si1.trans_date between @StartDate and @EndDate) * 100), 2) as Percentage
from sales_invoice as si
left join sales_invoice_detail as sid
on sid.id_sales_invoice = si.id_sales_invoice
left join items as i
on i.id_item = sid.id_item
left join item_tag_detail as itd
on itd.id_item = i.id_item
left join item_tag as it
on it.id_tag = itd.id_tag
where si.trans_date
between @StartDate and @EndDate
and si.id_company = 1
group by it.id_tag
order by it.id_tag
