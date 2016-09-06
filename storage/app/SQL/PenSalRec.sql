select c.code,
	c.name,
	c.alias,
	c.address,
	c.telephone,
	s.number,
	s.trans_date,
	paymentschedual.detalle,
	paymentschedual.monto,
	paymentschedual.monto - paymentschedual.credit as pendiente
from 
	sales_invoice as s
    left join
	 (select 	
		ps.trans_date,
		ps.id_sales_invoice,
		ps.id_sales_return,
		case when ps.id_sales_invoice is not null then 'Venta'
			 when ps.id_sales_return is not null then 'Nota de credito'
		END as detalle,
		case when ps.id_sales_invoice is not null then sum(ps.debit)
			 when ps.id_sales_return is not null then sum(credit.credit)
		END as monto,
		sum(ifnull(credit.credit,0)) as credit
	 from
		(select 
			trans_date,
			id_payment_schedual, 
			id_sales_invoice,
			id_sales_return, 
			debit from payment_schedual
            where trans_date>=@StartDate 
            and trans_date<=@EndDate
            and id_company = 1) as ps
		left join
		(select parent_id_payment_schedual,
				sum(credit) as credit 
			from payment_schedual 
            where trans_date>=@StartDate 
            and trans_date<=@EndDate
            group by 
            parent_id_payment_schedual) as credit
		on ps.id_payment_schedual = credit.parent_id_payment_Schedual
		group by ps.id_sales_invoice)
	as paymentschedual
    on paymentschedual.id_sales_invoice = s.id_sales_invoice
    left join contacts as c
	on c.id_contact = s.id_contact
    where s.trans_date>=@StartDate 
    and s.trans_date <= @EndDate 
    and s.status = 2 and 
    s.id_company = 1
    having pendiente > 0
    order by pendiente desc,paymentschedual.trans_date,s.number;